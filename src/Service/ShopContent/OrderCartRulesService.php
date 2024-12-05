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
use PrestaShop\Module\PsEventbus\Repository\OrderCartRuleRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderCartRulesService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var OrderCartRuleRepository */
    private $orderCartRuleRepository;

    public function __construct(OrderCartRuleRepository $orderCartRuleRepository)
    {
        $this->orderCartRuleRepository = $orderCartRuleRepository;
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
        $result = $this->orderCartRuleRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castOrderCartRules($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_ORDER_CART_RULES,
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
        $result = $this->orderCartRuleRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castOrderCartRules($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_ORDER_CART_RULES, $result, $deletedContents);
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
        return $this->orderCartRuleRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $orderCartRules
     *
     * @return void
     */
    private function castOrderCartRules(&$orderCartRules)
    {
        foreach ($orderCartRules as &$orderCartRule) {
            $orderCartRule['id_order_cart_rule'] = (int) $orderCartRule['id_order_cart_rule'];
            $orderCartRule['id_order'] = (int) $orderCartRule['id_order'];
            $orderCartRule['id_cart_rule'] = (int) $orderCartRule['id_cart_rule'];
            $orderCartRule['id_order_invoice'] = (int) $orderCartRule['id_order_invoice'];
            $orderCartRule['value'] = (float) $orderCartRule['value'];
            $orderCartRule['value_tax_excl'] = (float) $orderCartRule['value_tax_excl'];
            $orderCartRule['free_shipping'] = (bool) $orderCartRule['free_shipping'];
            $orderCartRule['deleted'] = isset($orderCartRule['deleted']) ? (bool) $orderCartRule['deleted'] : false;
        }
    }
}
