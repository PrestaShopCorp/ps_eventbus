<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\GoogleTaxonomyRepository;

class GoogleTaxonomyDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var GoogleTaxonomyRepository
     */
    private $googleTaxonomyRepository;
    /**
     * @var \Context
     */
    private $context;

    /**
     * @var int
     */
    private $shopId;

    public function __construct(GoogleTaxonomyRepository $googleTaxonomyRepository, \Context $context)
    {
        $this->googleTaxonomyRepository = $googleTaxonomyRepository;
        $this->context = $context;

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    public function getFormattedData($offset, $limit, $langIso)
    {
        $data = $this->googleTaxonomyRepository->getTaxonomyCategories($offset, $limit, $this->shopId);

        if (!is_array($data)) {
            return [];
        }

        return array_map(function ($googleTaxonomy) {
            $uniqueId = "{$googleTaxonomy['id_category']}-{$googleTaxonomy['id_category']}";
            $googleTaxonomy['taxonomy_id'] = $uniqueId;

            return [
                'id' => $uniqueId,
                'collection' => Config::COLLECTION_TAXONOMIES,
                'properties' => $googleTaxonomy,
            ];
        }, $data);
    }

    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->googleTaxonomyRepository->getRemainingTaxonomyRepositories($offset, $this->shopId);
    }

    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        return [];
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->googleTaxonomyRepository->getQueryForDebug($offset, $limit, $this->shopId);
    }
}
