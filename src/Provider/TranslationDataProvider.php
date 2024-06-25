<?php

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
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        // translations are stored as xml files before version 1.7
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
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
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            return 0;
        }

        return (int) $this->translationRepository->getRemainingTranslationsCount($offset);
    }

    /**
     * @param int $limit
     * @param string $langIso
     * @param array $objectIds
     *
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        // translations are stored as xml files before version 1.7
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
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
     * @return array
     *
     * @@throws \PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->translationRepository->getQueryForDebug($offset, $limit);
    }
}
