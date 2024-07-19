<?php

namespace PrestaShop\Module\PsEventbus\Repository;

class CurrencyRepository
{
    /**
     * @var \Db
     */
    private $db;

    public function __construct()
    {
        $this->db = \Db::getInstance();
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
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCurrencies($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @param int $offset
     *
     * @return int
     */
    public function getRemainingCurrenciesCount($offset)
    {
        $query = $this->getBaseQuery()
            ->select('(COUNT(c.id_currency) - ' . (int) $offset . ') as count');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param int $limit
     * @param array $currencyIds
     *
     * @return array|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getCurrenciesIncremental($limit, $currencyIds)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->where('c.id_currency IN(' . implode(',', array_map('intval', $currencyIds)) . ')')
            ->limit($limit);

        return $this->db->executeS($dbQuery);
    }

    /**
     * @return \DbQuery
     */
    public function getBaseQuery()
    {
        $dbQuery = new \DbQuery();
        $dbQuery->from('currency', 'c');
        if ($this->isLangAvailable()) {
            $dbQuery->innerJoin('currency_lang', 'cl', 'cl.id_currency = c.id_currency');
        }

        return $dbQuery;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit)
    {
        $dbQuery = $this->getBaseQuery();

        $this->addSelectParameters($dbQuery);

        $dbQuery->limit($limit, $offset);

        $queryStringified = preg_replace('/\s+/', ' ', $dbQuery->build());

        return array_merge(
            (array) $dbQuery,
            ['queryStringified' => $queryStringified]
        );
    }

    /**
     * @param \DbQuery $dbQuery
     *
     * @return void
     */
    private function addSelectParameters(\DbQuery $dbQuery)
    {
        if ($this->isLangAvailable()) {
            $dbQuery->select('c.id_currency, cl.name, c.iso_code, c.conversion_rate, c.deleted, c.active');
        } else {
            $dbQuery->select('c.id_currency, \'\' as name, c.iso_code, c.conversion_rate, c.deleted, c.active');
        }

        // https://github.com/PrestaShop/PrestaShop/commit/37807f66b40b0cebb365ef952e919be15e9d6b2f#diff-3f41d3529ffdbfd1b994927eb91826a32a0560697025a734cf128a2c8e092a45R124
        if (version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
            $dbQuery->select('c.precision');
        }
    }
}
