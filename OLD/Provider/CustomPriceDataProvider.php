<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\CustomPriceDecorator;
use PrestaShop\Module\PsEventbus\Repository\CustomPriceRepository;

class CustomPriceDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var CustomPriceRepository
     */
    private $customPriceRepository;
    /**
     * @var CustomPriceDecorator
     */
    private $customPriceDecorator;

    public function __construct(
        CustomPriceRepository $customPriceRepository,
        CustomPriceDecorator $customPriceDecorator
    ) {
        $this->customPriceRepository = $customPriceRepository;
        $this->customPriceDecorator = $customPriceDecorator;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $specificPrices = $this->customPriceRepository->getSpecificPrices($offset, $limit);

        $this->customPriceDecorator->decorateSpecificPrices($specificPrices);

        return array_map(function ($specificPrice) {
            return [
                'id' => $specificPrice['id_specific_price'],
                'collection' => Config::COLLECTION_SPECIFIC_PRICES,
                'properties' => $specificPrice,
            ];
        }, $specificPrices);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->customPriceRepository->getRemainingSpecificPricesCount($offset);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array<mixed> $objectIds
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $specificPrices = $this->customPriceRepository->getSpecificPricesIncremental($limit, $objectIds);

        if (!empty($specificPrices)) {
            $this->customPriceDecorator->decorateSpecificPrices($specificPrices);
        } else {
            return [];
        }

        return array_map(function ($specificPrice) {
            return [
                'id' => $specificPrice['id_specific_price'],
                'collection' => Config::COLLECTION_SPECIFIC_PRICES,
                'properties' => $specificPrice,
            ];
        }, $specificPrices);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->customPriceRepository->getQueryForDebug($offset, $limit);
    }
}
