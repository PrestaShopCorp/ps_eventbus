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
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

class AdminPsEventbusController extends ModuleAdminController
{
    /** @var Ps_eventbus */
    public $module;

    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
    }

    public function initContent()
    {
        parent::initContent();

        $liveModeVuejs = (bool) getenv('LIVE_MODE_VUEJS');
        $isoCode = $this->context->language ? $this->context->language->iso_code : 'en';

        Media::addJsDef([
            'eventbusConfig' => [
                'isoCode' => $isoCode,
                'eventbusAjaxPath' => $this->context->link->getAdminLink('AdminPsEventbus'),
            ],
        ]);

        $assets = $this->getAssets();

        $this->context->smarty->assign([
            'LIVE_MODE_VUEJS' => $liveModeVuejs,
            'eventbus_js_url' => $assets['js'],
            'eventbus_css_url' => $assets['css'],
            'eventbus_preload_urls' => $assets['preload'],
        ]);

        $this->setTemplate('module:ps_eventbus/views/templates/admin/config.tpl');
    }

    /**
     * Read the Vite manifest and return asset URLs.
     *
     * @return array{js: string, css: string, preload: array<array{rel: string, as: string, href: string}>}
     */
    private function getAssets()
    {
        $result = ['js' => '', 'css' => '', 'preload' => []];
        $manifestPath = _PS_MODULE_DIR_ . $this->module->name . '/views/.vite/manifest.json';

        if (!file_exists($manifestPath)) {
            return $result;
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        if (!$manifest) {
            return $result;
        }

        $baseUrl = $this->context->link->getBaseLink() . 'modules/' . $this->module->name . '/views/';

        // Main entry point
        if (isset($manifest['js/main.js'])) {
            $entry = $manifest['js/main.js'];
            $result['js'] = $baseUrl . $entry['file'];

            // Preload imported chunks
            if (isset($entry['imports'])) {
                foreach ($entry['imports'] as $importKey) {
                    if (isset($manifest[$importKey])) {
                        $result['preload'][] = [
                            'rel' => 'modulepreload',
                            'as' => 'script',
                            'href' => $baseUrl . $manifest[$importKey]['file'],
                        ];
                    }
                }
            }

            // Preload dynamic imports (translations)
            $isoCode = $this->context->language ? $this->context->language->iso_code : 'en';
            if (isset($entry['dynamicImports'])) {
                foreach ($entry['dynamicImports'] as $dynamicKey) {
                    if (isset($manifest[$dynamicKey])) {
                        // Only preload the current locale translation
                        if (strpos($dynamicKey, 'translations/') === 0) {
                            $lang = str_replace(['translations/', '.json'], '', $dynamicKey);
                            if ($lang !== $isoCode) {
                                continue;
                            }
                        }
                        $result['preload'][] = [
                            'rel' => 'modulepreload',
                            'as' => 'script',
                            'href' => $baseUrl . $manifest[$dynamicKey]['file'],
                        ];
                    }
                }
            }
        }

        // CSS
        if (isset($manifest['style.css'])) {
            $result['css'] = $baseUrl . $manifest['style.css']['file'];
            $result['preload'][] = [
                'rel' => 'preload',
                'as' => 'style',
                'href' => $baseUrl . $manifest['style.css']['file'],
            ];
        }

        return $result;
    }
}
