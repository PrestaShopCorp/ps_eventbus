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
use PrestaShop\Module\PsEventbus\Repository\SupplierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SuppliersService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var SupplierRepository */
    private $supplierRepository;

    public function __construct(SupplierRepository $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
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
        $rawRows = $this->supplierRepository->retrieveContentsForFull($lastSeekKey, $limit, $langIso);

        $newSeekKey = $lastSeekKey;
        $rows = [];

        if (!empty($rawRows)) {
            $lastRow = end($rawRows);
            $newSeekKey = $this->padInt((int) $lastRow['id_supplier']);

            $this->castSuppliers($rawRows);

            $rows = array_map(function ($item) {
                return [
                    'action' => Config::INCREMENTAL_TYPE_UPSERT,
                    'collection' => Config::COLLECTION_SUPPLIERS,
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
        $result = $this->supplierRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castSuppliers($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_SUPPLIERS, $result, $deletedContents);
    }

    /**
     * @param string|null $lastSeekKey
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($lastSeekKey, $langIso)
    {
        return $this->supplierRepository->countFullSyncContentLeft($lastSeekKey, $langIso);
    }

    /**
     * @param array<mixed> $suppliers
     *
     * @return void
     */
    private function castSuppliers(&$suppliers)
    {
        foreach ($suppliers as &$supplier) {
            $supplier['id_supplier'] = (int) $supplier['id_supplier'];
            $supplier['active'] = (bool) $supplier['active'];
            $supplier['id_lang'] = (int) $supplier['id_lang'];
            $supplier['id_shop'] = (int) $supplier['id_shop'];
            $supplier['created_at'] = (string) $supplier['created_at'];
            $supplier['updated_at'] = (string) $supplier['updated_at'];
        }
    }
}
