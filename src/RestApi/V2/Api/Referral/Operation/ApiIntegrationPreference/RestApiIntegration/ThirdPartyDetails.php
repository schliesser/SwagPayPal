<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\RestApi\V2\Api\Referral\Operation\ApiIntegrationPreference\RestApiIntegration;

use OpenApi\Annotations as OA;
use Swag\PayPal\RestApi\PayPalApiStruct;

/**
 * @OA\Schema(schema="swag_paypal_v2_referral_third_party_details")
 */
class ThirdPartyDetails extends PayPalApiStruct
{
    public const FEATURE_TYPE_PAYMENT = 'PAYMENT';
    public const FEATURE_TYPE_REFUND = 'REFUND';
    public const FEATURE_TYPE_ACCESS_MERCHANT_INFORMATION = 'ACCESS_MERCHANT_INFORMATION';
    public const FEATURE_TYPE_ADVANCED_TRANSACTIONS_SEARCH = 'ADVANCED_TRANSACTIONS_SEARCH';
    public const FEATURE_TYPE_UPDATE_SELLER_DISPUTE = 'UPDATE_SELLER_DISPUTE';
    public const FEATURE_TYPE_READ_SELLER_DISPUTE = 'READ_SELLER_DISPUTE';
    public const FEATURE_TYPE_DELAY_FUNDS_DISBURSEMENT = 'DELAY_FUNDS_DISBURSEMENT';

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var string[]
     * @OA\Property(type="array", items={"type": "string"})
     */
    protected $features = [
        self::FEATURE_TYPE_PAYMENT,
        self::FEATURE_TYPE_REFUND,
        self::FEATURE_TYPE_ACCESS_MERCHANT_INFORMATION,
        self::FEATURE_TYPE_ADVANCED_TRANSACTIONS_SEARCH,
        self::FEATURE_TYPE_UPDATE_SELLER_DISPUTE,
        self::FEATURE_TYPE_READ_SELLER_DISPUTE,
        self::FEATURE_TYPE_DELAY_FUNDS_DISBURSEMENT,
    ];

    /**
     * @return string[]
     */
    public function getFeatures(): array
    {
        return $this->features;
    }

    /**
     * @param string[] $features
     */
    public function setFeatures(array $features): void
    {
        $this->features = $features;
    }
}
