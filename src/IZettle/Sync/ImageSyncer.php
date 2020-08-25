<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\IZettle\Sync;

use Psr\Log\LoggerInterface;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\MultiFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\NotFilter;
use Shopware\Core\System\SalesChannel\SalesChannelEntity;
use Swag\PayPal\IZettle\Api\Image\BulkImageUpload;
use Swag\PayPal\IZettle\Api\Image\BulkImageUploadResponse\Uploaded;
use Swag\PayPal\IZettle\Api\Service\MediaConverter;
use Swag\PayPal\IZettle\DataAbstractionLayer\Entity\IZettleSalesChannelMediaCollection;
use Swag\PayPal\IZettle\DataAbstractionLayer\Entity\IZettleSalesChannelMediaEntity;
use Swag\PayPal\IZettle\Exception\InvalidMediaTypeException;
use Swag\PayPal\IZettle\Resource\ImageResource;

class ImageSyncer extends AbstractSyncer
{
    /**
     * @var EntityRepositoryInterface
     */
    private $iZettleMediaRepository;

    /**
     * @var MediaConverter
     */
    private $mediaConverter;

    /**
     * @var ImageResource
     */
    private $imageResource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        EntityRepositoryInterface $iZettleMediaRepository,
        MediaConverter $mediaConverter,
        ImageResource $imageResource,
        LoggerInterface $logger
    ) {
        $this->iZettleMediaRepository = $iZettleMediaRepository;
        $this->mediaConverter = $mediaConverter;
        $this->imageResource = $imageResource;
        $this->logger = $logger;
    }

    /**
     * @param IZettleSalesChannelMediaCollection $entityCollection
     */
    public function sync(
        EntityCollection $entityCollection,
        SalesChannelEntity $salesChannel,
        Context $context
    ): void {
        $iZettleSalesChannel = $this->getIZettleSalesChannel($salesChannel);

        $domain = $iZettleSalesChannel->getMediaDomain();

        $bulkUpload = new BulkImageUpload();

        foreach ($entityCollection as $entity) {
            try {
                /* @var IZettleSalesChannelMediaEntity $entity */
                $upload = $this->mediaConverter->convert($domain, $entity->getMedia(), $entity->getLookupKey());

                $bulkUpload->addImageUpload($upload);
            } catch (InvalidMediaTypeException $invalidMediaTypeException) {
                $this->logger->warning(
                    'Media Type {mimeType} is not supported by iZettle. Skipping image {fileName}.',
                    [
                        'mimeType' => $entity->getMedia()->getMimeType(),
                        'fileName' => $entity->getMedia()->getFileName() . '.' . $entity->getMedia()->getFileExtension(),
                    ]
                );
            }
        }

        $response = $this->imageResource->bulkUploadPictures($iZettleSalesChannel, $bulkUpload);
        if ($response === null) {
            return;
        }

        $updates = [];
        foreach ($response->getUploaded() as $uploaded) {
            $update = $this->prepareMediaUpdate($entityCollection, $uploaded, $iZettleSalesChannel->getSalesChannelId());
            if ($update !== null) {
                $updates[] = $update;
            }
        }

        if (\count($updates) > 0) {
            $this->iZettleMediaRepository->upsert($updates, $context);
            $this->logger->info('Successfully uploaded {count} images.', [
                'count' => \count($updates),
            ]);
        }

        foreach ($response->getInvalid() as $invalid) {
            $this->logger->warning('Upload was not accepted by iZettle (is the URL publicly available?): {invalid}', [
                'invalid' => $invalid,
            ]);
        }
    }

    public function getCriteria(string $salesChannelId): Criteria
    {
        $criteria = new Criteria();
        $criteria->addFilter(
            new EqualsFilter('salesChannelId', $salesChannelId),
            new MultiFilter(MultiFilter::CONNECTION_OR, [
                new EqualsFilter('url', null),
                new NotFilter(NotFilter::CONNECTION_OR, [new EqualsFilter('media.updatedAt', null)]),
            ])
        );

        return $criteria;
    }

    public function cleanUp(string $salesChannelId, Context $context): void
    {
        $criteria = new Criteria();
        $criteria->addFilter(
            new EqualsFilter('salesChannelId', $salesChannelId),
            new MultiFilter(MultiFilter::CONNECTION_AND, [
                new EqualsFilter('url', null),
                new EqualsFilter('lookupKey', null),
            ])
        );

        $ids = $this->iZettleMediaRepository->searchIds($criteria, $context)->getIds();
        if (!empty($ids)) {
            $this->iZettleMediaRepository->delete($ids, $context);
        }
    }

    private function prepareMediaUpdate(
        IZettleSalesChannelMediaCollection $iZettleMediaCollection,
        Uploaded $uploaded,
        string $salesChannelId
    ): ?array {
        $urlPath = \parse_url($uploaded->getSource(), PHP_URL_PATH);

        if (\is_string($urlPath)) {
            $iZettleMedia = $iZettleMediaCollection->filter(
                static function (IZettleSalesChannelMediaEntity $entity) use ($urlPath) {
                    return \mb_strpos($urlPath, $entity->getMedia()->getUrl()) !== false
                        || \mb_strpos($entity->getMedia()->getUrl(), $urlPath) !== false;
                }
            )->first();
        } else {
            $iZettleMedia = null;
        }

        if ($iZettleMedia === null) {
            $this->logger->warning('Could not match uploaded image to local media: {iZettleUrl}', [
                'iZettleUrl' => \current($uploaded->getImageUrls()),
            ]);

            return null;
        }

        return [
            'salesChannelId' => $salesChannelId,
            'mediaId' => $iZettleMedia->getMedia()->getId(),
            'lookupKey' => $uploaded->getImageLookupKey(),
            'url' => \current($uploaded->getImageUrls()),
        ];
    }
}
