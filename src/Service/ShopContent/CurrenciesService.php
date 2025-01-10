<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\CurrencyRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CurrenciesService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var CurrencyRepository */
    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->currencyRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castCurrencies($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_CURRENCIES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso)
    {
        $result = $this->currencyRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castCurrencies($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CURRENCIES, $result, $deletedContents);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->currencyRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @return array<mixed>
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
     * @param array<mixed> $currencies
     *
     * @return void
     */
    private function castCurrencies(&$currencies)
    {
        foreach ($currencies as &$currency) {
            $currency['id_currency'] = (int) $currency['id_currency'];
            $currency['conversion_rate'] = (float) $currency['conversion_rate'];
            $currency['deleted'] = (bool) $currency['deleted'];
            $currency['active'] = (bool) $currency['active'];

            // https://github.com/PrestaShop/PrestaShop/commit/37807f66b40b0cebb365ef952e919be15e9d6b2f#diff-3f41d3529ffdbfd1b994927eb91826a32a0560697025a734cf128a2c8e092a45R124
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.6.0', '>=')) {
                $currency['precision'] = (int) $currency['precision'];
            }
        }
    }
}
