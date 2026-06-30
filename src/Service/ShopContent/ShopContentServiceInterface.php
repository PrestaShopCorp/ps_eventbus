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

interface ShopContentServiceInterface
{
    /**
     * Zero-pad width for INT UNSIGNED primary keys (max 4 294 967 295,
     * 10 digits + 1 headroom).
     */
    const SEEK_KEY_PAD_INT = 11;

    /**
     * Zero-pad width for BIGINT UNSIGNED primary keys (max
     * 18 446 744 073 709 551 615, 20 digits).
     */
    const SEEK_KEY_PAD_BIGINT = 20;

    /**
     * Fetch one page of full-sync content strictly after $lastSeekKey.
     *
     * @param string|null $lastSeekKey cursor from the previous page, or null on first call
     * @param int $limit
     * @param string $langIso
     *
     * @return array{rows: array<mixed>, lastSeekKey: ?string}
     */
    public function getContentsForFull($lastSeekKey, $limit, $langIso);

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso);

    /**
     * @param string|null $lastSeekKey
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($lastSeekKey, $langIso);

    /**
     * Encode an outbox id_object string (as written by
     * SynchronizationService::insertContentIntoIncremental) into the same
     * lexicographically comparable form used for seek keys, so the outbox
     * gate can compare them with strcmp.
     *
     * @param string $idObject
     *
     * @return string
     */
    public function encodeOutboxIdAsSeekKey($idObject);
}
