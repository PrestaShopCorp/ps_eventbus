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
use PrestaShop\Module\PsEventbus\Repository\TranslationRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class TranslationsService implements ShopContentServiceInterface
{
    /** @var TranslationRepository */
    private $translationRepository;

    public function __construct(TranslationRepository $translationRepository)
    {
        $this->translationRepository = $translationRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $explainSql)
    {
        $result = $this->translationRepository->retrieveContentsForFull($offset, $limit, $langIso, $explainSql);

        if (empty($result)) {
            return [];
        }

        $this->castTranslations($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_lang'],
                'collection' => Config::COLLECTION_TRANSLATIONS,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $explainSql
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $explainSql)
    {
        $result = $this->translationRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $explainSql);

        if (empty($result)) {
            return [];
        }

        $this->castTranslations($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_lang'],
                'collection' => Config::COLLECTION_TRANSLATIONS,
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
        return $this->translationRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $translations
     *
     * @return void
     */
    private function castTranslations(&$translations)
    {
        foreach ($translations as &$translation) {
            $translation['id_translation'] = (int) $translation['id_translation'];
            $translation['id_lang'] = (int) $translation['id_lang'];
            $translation['key'] = (string) $translation['key'];
            $translation['translation'] = (string) $translation['translation'];
            $translation['domain'] = (string) $translation['domain'];
            $translation['theme'] = (string) $translation['theme'];
        }
    }
}
