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

if (!defined('_PS_VERSION_')) {
    exit;
}

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\TranslationDecorator;
use PrestaShop\Module\PsEventbus\Repository\TranslationRepository;

class TranslationDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var TranslationRepository
     */
    private $translationRepository;

    /**
     * @var TranslationDecorator
     */
    private $translationDecorator;

    public function __construct(TranslationRepository $translationRepository, TranslationDecorator $translationDecorator)
    {
        $this->translationRepository = $translationRepository;
        $this->translationDecorator = $translationDecorator;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        // translations are stored as xml files before version 1.7
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '<')) {
            return [];
        }

        $translations = $this->translationRepository->getTranslations($offset, $limit);

        if (!is_array($translations)) {
            return [];
        }
        $this->translationDecorator->decorateTranslations($translations);

        return array_map(function ($translation) {
            return [
                'id' => $translation['id_lang'],
                'collection' => Config::COLLECTION_TRANSLATIONS,
                'properties' => $translation,
            ];
        }, $translations);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        // translations are stored as xml files before version 1.7
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '<')) {
            return 0;
        }

        return (int) $this->translationRepository->getRemainingTranslationsCount($offset);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array<mixed> $objectIds
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        // translations are stored as xml files before version 1.7
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '<')) {
            return [];
        }

        $translations = $this->translationRepository->getTranslationsIncremental($limit, $objectIds);

        if (!is_array($translations)) {
            return [];
        }
        $this->translationDecorator->decorateTranslations($translations);

        return array_map(function ($translation) {
            return [
                'id' => $translation['id_lang'],
                'collection' => Config::COLLECTION_TRANSLATIONS,
                'properties' => $translation,
            ];
        }, $translations);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->translationRepository->getQueryForDebug($offset, $limit);
    }
}
