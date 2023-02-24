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
    }
}
