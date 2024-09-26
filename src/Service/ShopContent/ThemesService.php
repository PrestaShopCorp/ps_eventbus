<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\PrestaShop\Core\Addon\Theme\ThemeManagerBuilder;

class ThemesService implements ShopContentServiceInterface
{
    /** @var \Context */
    private $context;

    public function __construct(\Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->getAllThemes();

        if (empty($result)) {
            return [];
        }

        $themes = $this->formatThemes($result);

        return array_map(function ($item) {
            return [
                'id' => $item['theme_id'],
                'collection' => Config::COLLECTION_THEMES,
                'properties' => $item,
            ];
        }, $themes);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->getAllThemes();

        if (empty($result)) {
            return [];
        }

        $themes = $this->formatThemes($result);

        return array_map(function ($item) {
            return [
                'id' => $item['theme_id'],
                'collection' => Config::COLLECTION_THEMES,
                'properties' => $item,
            ];
        }, $themes);
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
        return 0;
    }

    /**
     * Get all Themes
     *
     * @return mixed
     *
     * @throws \PrestaShopException
     */
    private function getAllThemes()
    {
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>')) {
            if ($this->context->shop === null) {
                throw new \PrestaShopException('No shop context');
            }

            $themeRepository = (new ThemeManagerBuilder($this->context, \Db::getInstance()))->buildRepository($this->context->shop);

            return $themeRepository->getList();
        } else {
            /* @phpstan-ignore-next-line */
            return \Theme::getAvailable(false);
        }
    }

    /**
     * @param array<mixed> $themes
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     */
    private function formatThemes($themes)
    {
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>')) {
            if ($this->context->shop === null) {
                throw new \PrestaShopException('No shop context');
            }

            $currentTheme = $this->context->shop->theme;

            return array_map(function ($key, $theme) use ($currentTheme) {
                return [
                    'theme_id' => md5((string) $key),
                    'name' => (string) $theme->getName(),
                    'theme_version' => (string) $theme->get('version'),
                    'active' => $theme->getName() == $currentTheme->getName(),
                ];
            }, array_keys($themes), $themes);
        } else {
            return array_map(function ($theme) {
                /* @phpstan-ignore-next-line */
                $themeObj = \Theme::getByDirectory($theme);

                /* @phpstan-ignore-next-line */
                if ($themeObj instanceof \Theme) {
                    /* @phpstan-ignore-next-line */
                    $themeInfo = \Theme::getThemeInfo($themeObj->id);

                    return [
                        'theme_id' => md5($theme),
                        'name' => isset($themeInfo['theme_name']) ? $themeInfo['theme_name'] : '',
                        'theme_version' => isset($themeInfo['theme_version']) ? $themeInfo['theme_version'] : '',
                        'active' => isset($themeInfo['theme_version']) ? false : (string) $this->context->theme->id == (string) $themeInfo['theme_id'],
                    ];
                } else {
                    return [
                        'theme_id' => md5($theme),
                        'name' => $theme,
                        'theme_version' => '',
                        'active' => false,
                    ];
                }
            }, $themes);
        }
    }
}
