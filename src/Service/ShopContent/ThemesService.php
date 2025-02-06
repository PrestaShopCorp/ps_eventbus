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
use PrestaShop\PrestaShop\Core\Addon\Theme\ThemeManagerBuilder;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ThemesService extends ShopContentAbstractService implements ShopContentServiceInterface
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
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->getAllThemes();

        if (empty($result)) {
            return [];
        }

        $themes = $this->formatThemes($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_THEMES,
                'properties' => $item,
            ];
        }, $themes);
    }

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso)
    {
        return [];
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
