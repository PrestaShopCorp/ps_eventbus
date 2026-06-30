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
use PrestaShop\Module\PsEventbus\Repository\BundleRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class BundlesService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var BundleRepository */
    private $bundleRepository;

    public function __construct(BundleRepository $bundleRepository)
    {
        $this->bundleRepository = $bundleRepository;
    }

    /**
     * @param string|null $lastSeekKey
     * @param int $limit
     * @param string $langIso
     *
     * @return array{rows: array<mixed>, lastSeekKey: ?string}
     */
    public function getContentsForFull($lastSeekKey, $limit, $langIso)
    {
        $rawRows = $this->bundleRepository->retrieveContentsForFull($lastSeekKey, $limit, $langIso);

        $newSeekKey = $lastSeekKey;
        $rows = [];

        if (!empty($rawRows)) {
            $lastRow = end($rawRows);
            $newSeekKey = $this->padInt((int) $lastRow['id_bundle']);

            $this->castBundles($rawRows);

            $rows = array_map(function ($item) {
                return [
                    'action' => Config::INCREMENTAL_TYPE_UPSERT,
                    'collection' => Config::COLLECTION_BUNDLES,
                    'properties' => $item,
                ];
            }, $rawRows);
        }

        return [
            'rows' => $rows,
            'lastSeekKey' => $newSeekKey,
        ];
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
        $result = $this->bundleRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castBundles($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_BUNDLES, $result, $deletedContents);
    }

    /**
     * @param string|null $lastSeekKey
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($lastSeekKey, $langIso)
    {
        return $this->bundleRepository->countFullSyncContentLeft($lastSeekKey, $langIso);
    }

    /**
     * @param array<mixed> $bundles
     *
     * @return void
     */
    private function castBundles(&$bundles)
    {
        foreach ($bundles as &$bundle) {
            $bundle['id_product'] = (string) $bundle['id_product'];
            $bundle['id_bundle'] = (string) $bundle['id_bundle'];
            $bundle['id_product_attribute'] = (string) $bundle['id_product_attribute'];
            $bundle['quantity'] = (string) $bundle['quantity'];
        }
    }
}
