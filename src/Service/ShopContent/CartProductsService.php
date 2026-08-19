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
use PrestaShop\Module\PsEventbus\Repository\CartProductRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CartProductsService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var CartProductRepository */
    private $cartProductRepository;

    public function __construct(CartProductRepository $cartProductRepository)
    {
        $this->cartProductRepository = $cartProductRepository;
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
        $result = $this->cartProductRepository->retrieveContentsForFull($lastSeekKey, $limit, $langIso);

        $newSeekKey = $lastSeekKey;
        $rows = [];

        if (!empty($result)) {
            $lastRow = end($result);
            $newSeekKey = ((int) $lastRow['id_cart'])
                . '-' . ((int) $lastRow['id_product'])
                . '-' . ((int) $lastRow['id_product_attribute']);

            $this->castCartProducts($result);

            $rows = array_map(function ($item) {
                return [
                    'action' => Config::INCREMENTAL_TYPE_UPSERT,
                    'collection' => Config::COLLECTION_CART_PRODUCTS,
                    'properties' => $item,
                ];
            }, $result);
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
        $result = $this->cartProductRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (!empty($result)) {
            $this->castCartProducts($result);
        }

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_CART_PRODUCTS, $result, $deletedContents);
    }

    /**
     * @param string|null $lastSeekKey
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($lastSeekKey, $langIso)
    {
        return $this->cartProductRepository->countFullSyncContentLeft($lastSeekKey, $langIso);
    }

    /**
     * The cursor is a composite "{id_cart}-{id_product}-{id_product_attribute}"
     * triple while the outbox records mutations per id_cart, so the two are not
     * directly comparable. Always record: over-recording during full sync is
     * safe (incremental sync re-uploads the extra rows), while under-recording
     * could drop a mutation to an already-uploaded cart.
     *
     * {@inheritdoc}
     */
    public function isAtOrBehindSeekKey($id, $cursor)
    {
        return true;
    }

    /**
     * @param array<mixed> $cartProducts
     *
     * @return void
     */
    private function castCartProducts(&$cartProducts)
    {
        foreach ($cartProducts as &$cartProduct) {
            $cartProduct['id_cart_product'] = (string) "{$cartProduct['id_cart']}-{$cartProduct['id_product']}-{$cartProduct['id_product_attribute']}";
            $cartProduct['id_cart'] = (string) $cartProduct['id_cart'];
            $cartProduct['id_product'] = (string) $cartProduct['id_product'];
            $cartProduct['id_product_attribute'] = (string) $cartProduct['id_product_attribute'];
            $cartProduct['quantity'] = (int) $cartProduct['quantity'];
        }
    }
}
