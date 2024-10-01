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

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\TaxonomyRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class TaxonomiesService implements ShopContentServiceInterface
{
    /** @var TaxonomyRepository */
    private $taxonomyRepository;

    public function __construct(TaxonomyRepository $taxonomyRepository)
    {
        $this->taxonomyRepository = $taxonomyRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->taxonomyRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castTaxonomies($result);

        return array_map(function ($item) {
            return [
                'id' => $item['taxonomy_id'],
                'collection' => Config::COLLECTION_TAXONOMIES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->taxonomyRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castTaxonomies($result);

        return array_map(function ($item) {
            return [
                'id' => $item['taxonomy_id'],
                'collection' => Config::COLLECTION_TAXONOMIES,
                'properties' => $item,
            ];
        }, $result);
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
        return $this->taxonomyRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $taxonomies
     *
     * @return void
     */
    private function castTaxonomies(&$taxonomies)
    {
        foreach ($taxonomies as &$taxonomy) {
            $googleTaxonomy['taxonomy_id'] = "{$taxonomy['id_category']}-{$taxonomy['id_category']}";
        }
    }
}
