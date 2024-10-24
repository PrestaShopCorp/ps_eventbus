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

if (!defined('_PS_VERSION_')) {
    exit;
}

abstract class ShopContentAbstractService
{
    protected function formatIncrementalSyncResponse($collection, $idKeyForBinding, $upsertedContents, $upsertedList, $deletedList)
    {
        $data = [];

        // We need to bind the upserted data with list of upserted content from incremental table to get the action
        foreach ($upsertedContents as $upsertedContent) {
            foreach ($upsertedList as $item) {
                if ($upsertedContent[$idKeyForBinding] == $item['id']) {
                    $data[] = [
                        'collection' => $collection,
                        'properties' => $upsertedContent,
                        'action' => $item['action'],
                    ];
                }
            }
        }

        // We need to format the deleted data to match the format of the upserted data
        foreach ($deletedList as $item) {
            $data[] = [
                'collection' => $collection,
                'properties' => [
                ],
                'action' => $item['action'],
            ];
        }

        return $data;
    }
}
