<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\RestApi\V1\Api\Disputes\Item;

use OpenApi\Annotations as OA;
use Swag\PayPal\RestApi\PayPalApiStruct;

/**
 * @OA\Schema(schema="swag_paypal_v1_disputes_message")
 */
class Message extends PayPalApiStruct
{
    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var string
     * @OA\Property(type="string")
     */
    protected $postedBy;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var string
     * @OA\Property(type="string")
     */
    protected $timePosted;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var string
     * @OA\Property(type="string")
     */
    protected $content;

    public function getPostedBy(): string
    {
        return $this->postedBy;
    }

    public function setPostedBy(string $postedBy): void
    {
        $this->postedBy = $postedBy;
    }

    public function getTimePosted(): string
    {
        return $this->timePosted;
    }

    public function setTimePosted(string $timePosted): void
    {
        $this->timePosted = $timePosted;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
