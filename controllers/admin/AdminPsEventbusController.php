<?php

class AdminPsEventbusController extends ModuleAdminController
{
    /** @var Ps_eventbus */
    public $module;

    public function __construct()
    {
        parent::__construct();
        $this->bootstrap = true;
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
        $isoCode = $this->context->language ? $this->context->language->iso_code : 'en';

        $moduleBaseUrl = $link->getBaseLink() . 'modules/' . $this->module->name . '/';

        Media::addJsDef([
            'eventbusConfig' => [
                'isoCode' => $isoCode,
                'eventbusAjaxPath' => $link->getAdminLink('AdminPsEventbus'),
                'logoUrl' => $moduleBaseUrl . 'logo.png',
                'moduleVersion' => $this->module->version,
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

        /** @var Link $link */
        $link = $this->context->link;
        $baseUrl = $link->getBaseLink() . 'modules/' . $this->module->name . '/views/';

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
