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

namespace PrestaShop\Module\PsEventbus\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class LanguageRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'lang';

    /**
     * @param string $langIso
     * @param bool $withSelecParameters
     *
     * @return void
     *
     * @throws \PrestaShopException
     */
    public function generateFullQuery($langIso, $withSelecParameters)
    {
        $this->generateMinimalQuery(self::TABLE_NAME, 'la');

        $this->query->innerJoin('lang_shop', 'las', 'la.id_lang = las.id_lang AND las.id_shop = ' . parent::getShopContext()->id);

        if ($withSelecParameters) {
            $this->query
                ->select('la.id_lang')
                ->select('la.name')
                ->select('la.active')
                ->select('la.iso_code')
                ->select('la.language_code')
                ->select('la.date_format_lite')
                ->select('la.date_format_full')
                ->select('la.is_rtl')
                ->select('las.id_shop')
                ->orderBy('la.id_lang ASC')
            ;

            // https://github.com/PrestaShop/PrestaShop/commit/481111b8274ed005e1c4a8ce2cf2b3ebbeb9a270#diff-c123d3d30d9c9e012a826a21887fccce6600a2f2a848a58d5910e55f0f8f5093R41
            if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7.0.0', '>=')) {
                $this->query->select('la.locale');
            }
        }
    }

    /**
     * Seek-based page: returns rows strictly after $lastSeekKey, ordered by la.id_lang.
     *
     * @param string|null $lastSeekKey
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForFull($lastSeekKey, $limit, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        if ($lastSeekKey !== null) {
            $this->query->where('la.id_lang > ' . (int) $lastSeekKey);
        }

        $this->query->limit((int) $limit);

        return $this->runQuery();
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function retrieveContentsForIncremental($limit, $contentIds, $langIso)
    {
        $this->generateFullQuery($langIso, true);

        $this->query
            ->where("la.id_lang IN('" . implode("','", array_map('intval', $contentIds ?: [-1])) . "')")
            ->limit($limit)
        ;

        return $this->runQuery();
    }

    /**
     * Count rows with la.id_lang > cursor.
     *
     * @param string|null $lastSeekKey
     * @param string $langIso
     *
     * @return int
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($lastSeekKey, $langIso)
    {
        $this->generateFullQuery($langIso, false);

        if ($lastSeekKey !== null) {
            $this->query->where('la.id_lang > ' . (int) $lastSeekKey);
        }

        $this->query->select('COUNT(*) as count');

        $result = $this->runQuery(true);

        return !empty($result[0]['count']) ? (int) $result[0]['count'] : 0;
    }
}
