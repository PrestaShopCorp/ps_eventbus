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
use PrestaShop\Module\PsEventbus\Repository\OrderCarrierRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderCarriersService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var OrderCarrierRepository */
    private $orderCarrierRepository;

    public function __construct(OrderCarrierRepository $orderCarrierRepository)
    {
        $this->orderCarrierRepository = $orderCarrierRepository;
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
        $result = $this->orderCarrierRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castOrderCarriers($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_ORDER_CARRIERS,
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
        $result = $this->orderCarrierRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castOrderCarriers($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_ORDER_CARRIERS, $result, $deletedContents);
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
        return $this->orderCarrierRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $orderCarriers
     *
     * @return void
     */
    private function castOrderCarriers(&$orderCarriers)
    {
        foreach ($orderCarriers as &$orderCarrier) {
            $orderCarrier['id_order_carrier'] = (string) $orderCarrier['id_order_carrier'];
            $orderCarrier['id_order'] = (string) $orderCarrier['id_order'];
            $orderCarrier['id_carrier'] = (string) $orderCarrier['id_carrier'];
            $orderCarrier['id_order_invoice'] = (string) $orderCarrier['id_order_invoice'];
            $orderCarrier['weight'] = (float) $orderCarrier['weight'];
            $orderCarrier['shipping_cost_tax_excl'] = (float) $orderCarrier['shipping_cost_tax_excl'];
            $orderCarrier['shipping_cost_tax_incl'] = (float) $orderCarrier['shipping_cost_tax_incl'];
        }
    }
}
