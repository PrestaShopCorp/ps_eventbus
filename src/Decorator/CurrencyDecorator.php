<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

class CurrencyDecorator
{
    /**
     * @param array $currencies
     *
     * @return void
     */
    public function decorateCurrencies(array &$currencies)
    {
        foreach ($currencies as &$currency) {
            $this->castPropertyValues($currency);
        }
    }

    /**
     * @param array $currency
     *
     * @return void
     */
    private function castPropertyValues(array &$currency)
    {
        $currency['id_currency'] = (int) $currency['id_currency'];
        $currency['conversion_rate'] = (float) $currency['conversion_rate'];
        $currency['deleted'] = (bool) $currency['deleted'];
        $currency['active'] = (bool) $currency['active'];

        // https://github.com/PrestaShop/PrestaShop/commit/37807f66b40b0cebb365ef952e919be15e9d6b2f#diff-3f41d3529ffdbfd1b994927eb91826a32a0560697025a734cf128a2c8e092a45R124
        if (version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
            $currency['precision'] = (int) $currency['precision'];
        }
    }
}
