<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\ApiHealthCheckService;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;

class AdminPsEventbusController extends ModuleAdminController
{
    /** @var Ps_eventbus */
    public $module;

    /** @var string */
    public $isoCode;

    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;

        /* @phpstan-ignore ternary.alwaysTrue */
        $this->isoCode = $this->context->language ? $this->context->language->iso_code : 'en';
    }

    /**
     * @return void
     */
    public function initContent()
    {
        parent::initContent();

        /** @var Link $link */
        $link = $this->context->link;

        $liveModeVuejs = (bool) $this->module->getServiceContainer()->getParameterWithDefault('ps_eventbus.live_mode_vuejs', 'false');

        $moduleBaseUrl = $this->getModuleBaseUrl();

        Media::addJsDef([
            'eventbusConfig' => [
                'isoCode' => $this->isoCode,
                'eventbusAjaxPath' => $link->getAdminLink('AdminPsEventbus'),
                'logoUrl' => $moduleBaseUrl . 'logo.png',
                'moduleVersion' => $this->module->version,
                'healthCheckUrl' => $link->getModuleLink('ps_eventbus', 'apiHealthCheck'),
                'shopContents' => Config::SHOP_CONTENTS,
                'shopId' => $this->getShopId(),
                'mockMode' => true,
                'cloudsyncApiUrl' => 'https://api.cloudsync.prestashop.com',
            ],
        ]);

        $assets = $this->getAssets();

        /** @var Smarty $smarty */
        $smarty = $this->context->smarty;

        $smarty->assign([
            'LIVE_MODE_VUEJS' => $liveModeVuejs,
            'eventbus_js_url' => $assets['js'],
            'eventbus_css_url' => $assets['css'],
            'eventbus_preload_urls' => $assets['preload'],
        ]);

        $templatePath = _PS_MODULE_DIR_ . $this->module->name . '/views/templates/admin/config.tpl';
        $this->content = $smarty->fetch($templatePath);
        $smarty->assign('content', $this->content);
    }

    /**
     * Build the module base URL without using Link::getBaseLink() which is protected in PS 1.6.
     *
     * @return string
     */
    private function getModuleBaseUrl()
    {
        $ssl = Tools::usingSecureMode();
        /** @var Shop $shop */
        $shop = $this->context->shop;
        $domain = $ssl ? $shop->domain_ssl : $shop->domain;

        return ($ssl ? 'https://' : 'http://') . $domain . $shop->getBaseURI() . 'modules/' . $this->module->name . '/';
    }

    /**
     * @return string
     */
    private function getShopId()
    {
        try {
            /** @var PsAccountsAdapterService $psAccounts */
            $psAccounts = $this->module->getService(PsAccountsAdapterService::class);

            return $psAccounts->getShopUuid();
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * AJAX action: return the health check data.
     *
     * @return void
     */
    public function ajaxProcessGetHealthCheck()
    {
        // With display_errors on (dev mode), PHP notices raised while building the
        // service are written to the response body and corrupt the JSON payload.
        $displayErrors = ini_get('display_errors');
        ini_set('display_errors', '0');
        ob_start();

        try {
            /** @var ApiHealthCheckService $healthCheckService */
            $healthCheckService = $this->module->getService(ApiHealthCheckService::class);
            $response = $healthCheckService->getDashboardHealthCheck();
        } catch (Exception $e) {
            $response = [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }

        ob_end_clean();
        ini_set('display_errors', (string) $displayErrors);

        // Not ajaxDie(): it was removed in PrestaShop 9, and ajaxRender() does not
        // exist in 1.6, which this module still supports.
        if (!headers_sent()) {
            header('Content-Type: application/json');
            header('Cache-Control: no-store, no-cache, must-revalidate');
        }

        echo (string) json_encode($response);

        exit;
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

        $manifestContent = file_get_contents($manifestPath);
        if ($manifestContent === false) {
            return $result;
        }

        $manifest = json_decode($manifestContent, true);
        if (!$manifest) {
            return $result;
        }

        $baseUrl = $this->getModuleBaseUrl() . 'views/';

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
            if (isset($entry['dynamicImports'])) {
                foreach ($entry['dynamicImports'] as $dynamicKey) {
                    if (isset($manifest[$dynamicKey])) {
                        // Only preload the current locale translation
                        if (strpos($dynamicKey, 'translations/') === 0) {
                            $lang = str_replace(['translations/', '.json'], '', $dynamicKey);
                            if ($lang !== $this->isoCode) {
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
