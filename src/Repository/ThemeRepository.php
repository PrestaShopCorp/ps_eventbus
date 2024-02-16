<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\PrestaShop\Core\Addon\Theme\ThemeManagerBuilder;

class ThemeRepository
{
    /**
     * @var PrestaShop\PrestaShop\Adapter\Entity\Context
     */
    private $context;
    /**
     * @var PrestaShop\PrestaShop\Adapter\Entity\Db
     */
    private $db;

    public function __construct(\Context $context, PrestaShop\PrestaShop\Adapter\Entity\Db $db)
    {
        $this->context = $context;
        $this->db = $db;
    }

    /**
     * @return array|mixed|null
     */
    public function getThemes()
    {
        if (version_compare(_PS_VERSION_, '1.7', '>')) {
            if ($this->context->shop === null) {
                throw new PrestaShop\PrestaShop\Adapter\Entity\PrestaShopException('No shop context');
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
            $themes = PrestaShop\PrestaShop\Adapter\Entity\Theme::getAvailable(false);

            return array_map(function ($theme) {
                /* @phpstan-ignore-next-line */
                $themeObj = PrestaShop\PrestaShop\Adapter\Entity\Theme::getByDirectory($theme);

                $themeData = [
                    'id' => md5($theme),
                    'collection' => Config::COLLECTION_THEMES,
                    'properties' => [],
                ];

                /* @phpstan-ignore-next-line */
                if ($themeObj instanceof PrestaShop\PrestaShop\Adapter\Entity\Theme) {
                    /* @phpstan-ignore-next-line */
                    $themeInfo = PrestaShop\PrestaShop\Adapter\Entity\Theme::getThemeInfo($themeObj->id);

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
