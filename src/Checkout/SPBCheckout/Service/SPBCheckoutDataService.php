<?php declare(strict_types=1);

namespace Swag\PayPal\Checkout\SPBCheckout\Service;

use Shopware\Core\Framework\DataAbstractionLayer\Exception\InconsistentCriteriaIdsException;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Swag\PayPal\Checkout\SPBCheckout\SPBCheckoutButtonData;
use Swag\PayPal\Setting\SwagPayPalSettingStruct;
use Swag\PayPal\Util\LocaleCodeProvider;
use Swag\PayPal\Util\PaymentMethodIdProvider;

class SPBCheckoutDataService
{
    /**
     * @var PaymentMethodIdProvider
     */
    private $paymentMethodIdProvider;

    /**
     * @var LocaleCodeProvider
     */
    private $localeCodeProvider;

    public function __construct(
        PaymentMethodIdProvider $paymentMethodIdProvider,
        LocaleCodeProvider $localeCodeProvider
    ) {
        $this->paymentMethodIdProvider = $paymentMethodIdProvider;
        $this->localeCodeProvider = $localeCodeProvider;
    }

    /**
     * @throws InconsistentCriteriaIdsException
     */
    public function getCheckoutData(
        SalesChannelContext $context,
        SwagPayPalSettingStruct $settings
    ): SPBCheckoutButtonData {
        $paymentMethodId = $this->paymentMethodIdProvider->getPayPalPaymentMethodId($context->getContext());
        $expressCheckoutData = (new SPBCheckoutButtonData())->assign([
            'clientId' => $settings->getClientId(),
            'useSandbox' => $settings->getSandbox(),
            'languageIso' => $this->getInContextButtonLanguage($settings, $context),
            'currency' => $context->getCurrency()->getIsoCode(),
            'intent' => $settings->getIntent(),
            'paymentMethodId' => $paymentMethodId,
            'useAlternativePaymentMethods' => $settings->getSpbAlternativePaymentMethodsEnabled(),
        ]);

        return $expressCheckoutData;
    }

    /**
     * @throws InconsistentCriteriaIdsException
     */
    private function getInContextButtonLanguage(SwagPayPalSettingStruct $settings, SalesChannelContext $context): string
    {
        if ($settingsLocale = $settings->getSpbButtonLanguageIso()) {
            return $settingsLocale;
        }

        return str_replace(
            '-',
            '_',
            $this->localeCodeProvider->getLocaleCodeFromContext($context->getContext())
        );
    }
}
