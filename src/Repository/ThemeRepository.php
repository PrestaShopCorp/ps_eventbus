<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\PrestaShop\Core\Addon\Theme\ThemeManagerBuilder;

class ThemeRepository
{
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var \Db
     */
    private $db;

    public function __construct(\Context $context)
    {
        $this->context = $context;
        $this->db = \Db::getInstance();
    }

    /**
     * @return array<mixed>|mixed|null
     */
    public function getThemes()
    {
        if (defined('_PS_VERSION_') && version_compare(_PS_VERSION_, '1.7', '>')) {
            if ($this->context->shop === null) {
                throw new \PrestaShopException('No shop context');
            }

            $themeRepository = (new ThemeManagerBuilder($this->context, $this->db))
                ->buildRepository($this->context->shop);

            $currentTheme = $this->context->shop->theme;
            $themes = $themeRepository->getList();

            return array_map(function ($key, $theme) use ($currentTheme) {
                return [
                    'id' => md5((string) $key),
                    'collection' => Config::COLLECTION_THEMES,
                    'properties' => [
                        'theme_id' => md5((string) $key),
                        'name' => (string) $theme->getName(),
                        'theme_version' => (string) $theme->get('version'),
                        'active' => $theme->getName() == $currentTheme->getName(),
                    ],
                ];
            }, array_keys($themes), $themes);
        } else {
            /* @phpstan-ignore-next-line */
            $themes = \Theme::getAvailable(false);

            return array_map(function ($theme) {
                /* @phpstan-ignore-next-line */
                $themeObj = \Theme::getByDirectory($theme);

                $themeData = [
                    'id' => md5($theme),
                    'collection' => Config::COLLECTION_THEMES,
                    'properties' => [],
                ];

                /* @phpstan-ignore-next-line */
                if ($themeObj instanceof \Theme) {
                    /* @phpstan-ignore-next-line */
                    $themeInfo = \Theme::getThemeInfo($themeObj->id);

                    $themeData['properties'] = [
                        'theme_id' => md5($theme),
                        'name' => isset($themeInfo['theme_name']) ? $themeInfo['theme_name'] : '',
                        'theme_version' => isset($themeInfo['theme_version']) ? $themeInfo['theme_version'] : '',
                        'active' => isset($themeInfo['theme_version']) ? false : (string) $this->context->theme->id == (string) $themeInfo['theme_id'],
                    ];
                } else {
                    $themeData['properties'] = [
                        'theme_id' => md5($theme),
                        'name' => $theme,
                        'theme_version' => '',
                        'active' => false,
                    ];
                }

                return $themeData;
            }, $themes);
        }
    }
}
