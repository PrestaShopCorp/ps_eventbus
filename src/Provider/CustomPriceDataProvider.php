<?php

namespace PrestaShop\Module\PsEventbus\Provider;

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
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $specificPrices = $this->customPriceRepository->getSpecificPrices($offset, $limit);

        $this->customPriceDecorator->decorateSpecificPrices($specificPrices);

        return array_map(function ($specificPrice) {
            return [
                'id' => $specificPrice['id_specific_price'],
                'collection' => 'specific_price',
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
     * @throws \PrestaShopDatabaseException
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->customPriceRepository->getRemainingSpecificPricesCount($offset);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $objectIds
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        $specificPrices = $this->customPriceRepository->getSpecificPricesIncremental($limit, $objectIds);

        if (!empty($specificPrices)) {
            $this->customPriceDecorator->decorateSpecificPrices($specificPrices);
        } else {
            return [];
        }

        return array_map(function ($product) {
            return [
                'id' => $product['unique_product_id'],
                'collection' => 'products',
                'properties' => $product,
            ];
        }, $specificPrices);
    }
}
