<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\RestApi\V2\Api;

use OpenApi\Annotations as OA;
use Swag\PayPal\RestApi\PayPalApiStruct;
use Swag\PayPal\RestApi\V2\Api\Referral\BusinessEntity;
use Swag\PayPal\RestApi\V2\Api\Referral\LegalConsent;
use Swag\PayPal\RestApi\V2\Api\Referral\Link;
use Swag\PayPal\RestApi\V2\Api\Referral\Operation;
use Swag\PayPal\RestApi\V2\Api\Referral\PartnerConfigOverride;

/**
 * @OA\Schema(schema="swag_paypal_v2_referral")
 */
class Referral extends PayPalApiStruct
{
    public const PRODUCT_TYPE_EXPRESS_CHECKOUT = 'EXPRESS_CHECKOUT';
    public const PRODUCT_TYPE_PPCP = 'PPCP';

    /**
     * @OA\Property(ref="#/components/schemas/swag_paypal_v2_referral_business_entity")
     */
    protected BusinessEntity $businessEntity;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var string
     * @OA\Property(type="string")
     */
    protected $preferredLanguageCode;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var string
     * @OA\Property(type="string")
     */
    protected $trackingId;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var PartnerConfigOverride
     * @OA\Property(ref="#/components/schemas/swag_paypal_v2_referral_partner_config_override")
     */
    protected $partnerConfigOverride;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var Operation[]
     * @OA\Property(type="array", items={"$ref": "#/components/schemas/swag_paypal_v2_referral_operation"})
     */
    protected $operations;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var string[]
     * @OA\Property(type="array", items={"type": "string"})
     */
    protected $products = [self::PRODUCT_TYPE_PPCP];

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var LegalConsent[]
     * @OA\Property(type="array", items={"$ref": "#/components/schemas/swag_paypal_v2_referral_legal_consent"})
     */
    protected $legalConsents;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var Link[]
     * @OA\Property(type="array", items={"$ref": "#/components/schemas/swag_paypal_v2_common_link"})
     */
    protected $links;

    public function getBusinessEntity(): BusinessEntity
    {
        return $this->businessEntity;
    }

    public function setBusinessEntity(BusinessEntity $businessEntity): void
    {
        $this->businessEntity = $businessEntity;
    }

    public function getPreferredLanguageCode(): string
    {
        return $this->preferredLanguageCode;
    }

    public function setPreferredLanguageCode(string $preferredLanguageCode): void
    {
        $this->preferredLanguageCode = $preferredLanguageCode;
    }

    public function getTrackingId(): string
    {
        return $this->trackingId;
    }

    public function setTrackingId(string $trackingId): void
    {
        $this->trackingId = $trackingId;
    }

    public function getPartnerConfigOverride(): PartnerConfigOverride
    {
        return $this->partnerConfigOverride;
    }

    public function setPartnerConfigOverride(PartnerConfigOverride $partnerConfigOverride): void
    {
        $this->partnerConfigOverride = $partnerConfigOverride;
    }

    /**
     * @return Operation[]
     */
    public function getOperations(): array
    {
        return $this->operations;
    }

    /**
     * @param Operation[] $operations
     */
    public function setOperations(array $operations): void
    {
        $this->operations = $operations;
    }

    /**
     * @return string[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param string[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    /**
     * @return LegalConsent[]
     */
    public function getLegalConsents(): array
    {
        return $this->legalConsents;
    }

    /**
     * @param LegalConsent[] $legalConsents
     */
    public function setLegalConsents(array $legalConsents): void
    {
        $this->legalConsents = $legalConsents;
    }

    /**
     * @return Link[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }

    /**
     * @param Link[] $links
     */
    public function setLinks(array $links): void
    {
        $this->links = $links;
    }
}
