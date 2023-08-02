<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CurrencyRepository
{
    /**
     * @var \Db
     */
    private $db;

    /**
     * @var \Context
     */
    private $context;

    public function __construct(\Db $db, \Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    private function isLangAvailable()
    {
        return \Tools::version_compare(_PS_VERSION_, '1.7.6', '>=');
    }

    /**
     * @return array
     */
    public function getCurrenciesIsoCodes()
    {
        $currencies = \Currency::getCurrencies();

        return array_map(function ($currency) {
            return $currency['iso_code'];
        }, $currencies);
    }

    /**
     * @return string
     */
    public function getDefaultCurrencyIsoCode()
    {
        $currency = \Currency::getDefaultCurrency();

        return $currency instanceof \Currency ? $currency->iso_code : '';
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCurrencies($offset, $limit, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso);

        $this->addSelectParameters($query);

        $query->limit($limit, $offset);

        return $this->db->executeS($query);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingCurrenciesCount($offset, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso)
            ->select('(COUNT(c.id_currency) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $currencyIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCurrenciesIncremental($limit, $langIso, $currencyIds)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $query = $this->getBaseQuery($shopId, $langIso);

        $this->addSelectParameters($query);

        $query->where('c.id_currency IN(' . implode(',', array_map('intval', $currencyIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($query);
    }

    /**
     * @param int $shopId
     * @param string $langIso
     *
     * @return \DbQuery
     */
    public function getBaseQuery($shopId, $langIso)
    {
        $query = new \DbQuery();
        $query->from('currency', 'c');
        if ($this->isLangAvailable()) {
            $query->innerJoin('currency_lang', 'cl', 'cl.id_currency = c.id_currency');
        }

        return $query;
    }

    /**
     * @param \DbQuery $query
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $query)
    {
        if ($this->isLangAvailable()) {
            $query->select('c.id_currency, cl.name, c.iso_code, c.conversion_rate, c.deleted, c.precision, c.active');
        } else {
            $query->select('c.id_currency, \'\' as name, c.iso_code, c.conversion_rate, c.deleted, c.precision, c.active');
        }
    }
}
