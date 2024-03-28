<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Decorator\LanguageDecorator;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;

class LanguageDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var LanguageRepository
     */
    private $languageRepository;

    /**
     * @var LanguageDecorator
     */
    private $languageDecorator;

    public function __construct(LanguageRepository $languageRepository, LanguageDecorator $languageDecorator)
    {
        $this->languageRepository = $languageRepository;
        $this->languageDecorator = $languageDecorator;
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
        $languages = $this->languageRepository->getLanguagesSync($offset, $limit);

        if (!is_array($languages)) {
            return [];
        }
        $this->languageDecorator->decorateLanguages($languages);

        return array_map(function ($language) {
            return [
                'id' => $language['id_lang'],
                'collection' => Config::COLLECTION_LANGUAGES,
                'properties' => $language,
            ];
        }, $languages);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->languageRepository->getRemainingLanguagesCount($offset);
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
        $languages = $this->languageRepository->getLanguagesIncremental($limit, $objectIds);

        if (!is_array($languages)) {
            return [];
        }
        $this->languageDecorator->decorateLanguages($languages);

        return array_map(function ($language) {
            return [
                'id' => $language['id_lang'],
                'collection' => Config::COLLECTION_LANGUAGES,
                'properties' => $language,
            ];
        }, $languages);
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
        return $this->languageRepository->getQueryForDebug($offset, $limit);
    }
}
