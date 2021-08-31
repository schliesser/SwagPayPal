<?php declare(strict_types=1);
/*
 * (c) shopware AG <info@shopware.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Swag\PayPal\RestApi\V2\Api\Order\PurchaseUnit\Payments\Refund;

use OpenApi\Annotations as OA;
use Swag\PayPal\RestApi\PayPalApiStruct;
use Swag\PayPal\RestApi\V2\Api\Order\PurchaseUnit\Payments\Refund\SellerPayableBreakdown\GrossAmount;
use Swag\PayPal\RestApi\V2\Api\Order\PurchaseUnit\Payments\Refund\SellerPayableBreakdown\NetAmount;
use Swag\PayPal\RestApi\V2\Api\Order\PurchaseUnit\Payments\Refund\SellerPayableBreakdown\PaypalFee;
use Swag\PayPal\RestApi\V2\Api\Order\PurchaseUnit\Payments\Refund\SellerPayableBreakdown\TotalRefundedAmount;

/**
 * @OA\Schema(schema="swag_paypal_v2_order_refund_seller_paypable_breakdown")
 */
class SellerPayableBreakdown extends PayPalApiStruct
{
    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var GrossAmount
     * @OA\Property(ref="#/components/schemas/swag_paypal_v2_common_money")
     */
    protected $grossAmount;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var PaypalFee
     * @OA\Property(ref="#/components/schemas/swag_paypal_v2_common_money")
     */
    protected $paypalFee;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var NetAmount
     * @OA\Property(ref="#/components/schemas/swag_paypal_v2_common_money")
     */
    protected $netAmount;

    /**
     * @deprecated tag:v4.0.0 - will be strongly typed
     *
     * @var TotalRefundedAmount
     * @OA\Property(ref="#/components/schemas/swag_paypal_v2_common_money")
     */
    protected $totalRefundedAmount;

    public function getGrossAmount(): GrossAmount
    {
        return $this->grossAmount;
    }

    public function setGrossAmount(GrossAmount $grossAmount): void
    {
        $this->grossAmount = $grossAmount;
    }

    public function getPaypalFee(): PaypalFee
    {
        return $this->paypalFee;
    }

    public function setPaypalFee(PaypalFee $paypalFee): void
    {
        $this->paypalFee = $paypalFee;
    }

    public function getNetAmount(): NetAmount
    {
        return $this->netAmount;
    }

    public function setNetAmount(NetAmount $netAmount): void
    {
        $this->netAmount = $netAmount;
    }

    public function getTotalRefundedAmount(): TotalRefundedAmount
    {
        return $this->totalRefundedAmount;
    }

    public function setTotalRefundedAmount(TotalRefundedAmount $totalRefundedAmount): void
    {
        $this->totalRefundedAmount = $totalRefundedAmount;
    }
}
