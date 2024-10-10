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
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class LanguagesService implements ShopContentServiceInterface
{
    /** @var LanguageRepository */
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
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
        $result = $this->languageRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castLanguages($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_lang'],
                'collection' => Config::COLLECTION_LANGUAGES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso)
    {
        $result = $this->languageRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castLanguages($result);

        return array_map(function ($item) {
            return [
                'id' => $item['id_lang'],
                'collection' => Config::COLLECTION_LANGUAGES,
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
        return $this->languageRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @return array<mixed>
     */
    public function getLanguagesIsoCodes()
    {
        /** @var array<mixed> $languages */
        $languages = \Language::getLanguages();

        return array_map(function ($language) {
            return $language['iso_code'];
        }, $languages);
    }

    /**
     * @return string
     */
    public function getDefaultLanguageIsoCode()
    {
        $language = \Language::getLanguage((int) \Configuration::get('PS_LANG_DEFAULT'));

        if (is_array($language)) {
            return $language['iso_code'];
        }

        return '';
    }

    /**
     * @param string $isoCode
     *
     * @return int
     */
    public function getLanguageIdByIsoCode($isoCode)
    {
        return (int) \Language::getIdByIso($isoCode);
    }

    /**
     * @return array<mixed>
     */
    public function getLanguages()
    {
        return \Language::getLanguages();
    }

    /**
     * @param array<mixed> $languages
     *
     * @return void
     */
    private function castLanguages(&$languages)
    {
        foreach ($languages as &$language) {
            $language['id_lang'] = (int) $language['id_lang'];
            $language['active'] = (bool) $language['active'];
            $language['is_rtl'] = (bool) $language['is_rtl'];
            $language['id_shop'] = (int) $language['id_shop'];
        }
    }
}
