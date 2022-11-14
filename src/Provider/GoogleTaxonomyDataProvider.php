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

    public function __construct(GoogleTaxonomyRepository $googleTaxonomyRepository, \Context $context)
    {
        $this->googleTaxonomyRepository = $googleTaxonomyRepository;
        $this->context = $context;
    }

    public function getFormattedData($offset, $limit, $langIso)
    {
        /** @var int $shopId */
        $shopId = $this->context->shop->id;
        $data = $this->googleTaxonomyRepository->getTaxonomyCategories($offset, $limit, $shopId);

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
        /** @var int $shopId */
        $shopId = $this->context->shop->id;

        return (int) $this->googleTaxonomyRepository->getRemainingTaxonomyRepositories($offset, $shopId);
    }

    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        return [];
    }
}
