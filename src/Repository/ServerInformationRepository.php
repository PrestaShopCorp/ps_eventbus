<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\AccountsAuth\Service\PsAccountsService;
use PrestaShop\Module\PsAccounts\Api\Client\AccountsClient;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandlerInterface;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

class ServerInformationRepository
{
    /**
     * @var CurrencyRepository
     */
    private $currencyRepository;
    /**
     * @var LanguageRepository
     */
    private $languageRepository;
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var \Db
     */
    private $db;
    /**
     * @var ShopRepository
     */
    private $shopRepository;
    /**
     * @var PsAccountsService
     */
    private $psAccountsService;
    /**
     * @var array
     */
    private $configuration;
    /**
     * @var string
     */
    private $createdAt;
    /**
     * @var ErrorHandlerInterface
     */
    private $errorHandler;

    public function __construct(
        \Context $context,
        \Db $db,
        CurrencyRepository $currencyRepository,
        LanguageRepository $languageRepository,
        ConfigurationRepository $configurationRepository,
        ShopRepository $shopRepository,
        PsAccounts $psAccounts,
        ErrorHandlerInterface $errorHandler,
        array $configuration
    ) {
        $this->currencyRepository = $currencyRepository;
        $this->languageRepository = $languageRepository;
        $this->configurationRepository = $configurationRepository;
        $this->shopRepository = $shopRepository;
        $this->context = $context;
        $this->db = $db;
        $this->psAccountsService = $psAccounts->getPsAccountsService();
        $this->configuration = $configuration;
        $this->createdAt = $this->shopRepository->getCreatedAt();
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param string $langIso
     *
     * @return array[]
     *
     * @throws \PrestaShopException
     */
    public function getServerInformation($langIso = '')
    {
        $langId = !empty($langIso) ? (int) \Language::getIdByIso($langIso) : null;
        $timezone = (string) $this->configurationRepository->get('PS_TIMEZONE');
        $createdAt = (new \DateTime($this->createdAt, new \DateTimeZone($timezone)))->format('Y-m-d\TH:i:sO');

        return [
            [
                'id' => '1',
                'collection' => Config::COLLECTION_SHOPS,
                'properties' => [
                    'created_at' => $createdAt,
                    'cms_version' => _PS_VERSION_,
                    'url_is_simplified' => $this->configurationRepository->get('PS_REWRITING_SETTINGS') == '1',
                    'cart_is_persistent' => $this->configurationRepository->get('PS_CART_FOLLOWING') == '1',
                    'default_language' => $this->languageRepository->getDefaultLanguageIsoCode(),
                    'languages' => implode(';', $this->languageRepository->getLanguagesIsoCodes()),
                    'default_currency' => $this->currencyRepository->getDefaultCurrencyIsoCode(),
                    'currencies' => implode(';', $this->currencyRepository->getCurrenciesIsoCodes()),
                    'weight_unit' => $this->configurationRepository->get('PS_WEIGHT_UNIT'),
                    'distance_unit' => $this->configurationRepository->get('PS_BASE_DISTANCE_UNIT'),
                    'volume_unit' => $this->configurationRepository->get('PS_VOLUME_UNIT'),
                    'dimension_unit' => $this->configurationRepository->get('PS_DIMENSION_UNIT'),
                    'timezone' => $timezone,
                    'is_order_return_enabled' => $this->configurationRepository->get('PS_ORDER_RETURN') == '1',
                    'order_return_nb_days' => (int) $this->configurationRepository->get('PS_ORDER_RETURN_NB_DAYS'),
                    'php_version' => phpversion(),
                    'http_server' => isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '',
                    'url' => $this->context->link->getPageLink('index', null, $langId),
                    'ssl' => $this->configurationRepository->get('PS_SSL_ENABLED') == '1',
                    'multi_shop_count' => $this->shopRepository->getMultiShopCount(),
                    'country_code' => $this->shopRepository->getShopCountryCode(),
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getHealthCheckData()
    {
        $tokenValid = false;
        $tokenIsSet = true;
        $allTablesInstalled = true;

        try {
            $token = $this->psAccountsService->getOrRefreshToken();

            if (!$token) {
                $tokenIsSet = false;
            } else {
                $accountsClient = $this->getAccountsClient();
                /** @phpstan-ignore-next-line */
                $response = $accountsClient->verifyToken($token);
                if ($response && true === $response['status']) {
                    $tokenValid = true;
                }
            }
        } catch (\Exception $e) {
            $this->errorHandler->handle($e);
            $tokenIsSet = false;
        }

        foreach (\Ps_eventbus::REQUIRED_TABLES as $requiredTable) {
            $query = new \DbQuery();

            $query->select('*')
                ->from($requiredTable)
                ->limit(1);

            try {
                $this->db->executeS($query);
            } catch (\PrestaShopDatabaseException $e) {
                $allTablesInstalled = false;
                break;
            }
        }

        if (defined('PHP_VERSION') && defined('PHP_EXTRA_VERSION')) {
            $phpVersion = str_replace(PHP_EXTRA_VERSION, '', PHP_VERSION);
        } else {
            $phpVersion = (string) explode('-', (string) phpversion())[0];
        }

        return [
            'prestashop_version' => _PS_VERSION_,
            'ps_eventbus_version' => \Ps_eventbus::VERSION,
            'ps_accounts_version' => defined('Ps_accounts::VERSION') ? \Ps_accounts::VERSION : false, /* @phpstan-ignore-line */
            'php_version' => $phpVersion,
            'ps_account' => $tokenIsSet,
            'is_valid_jwt' => $tokenValid,
            'ps_eventbus' => $allTablesInstalled,
            'env' => [
                'EVENT_BUS_PROXY_API_URL' => isset($this->configuration['EVENT_BUS_PROXY_API_URL']) ? $this->configuration['EVENT_BUS_PROXY_API_URL'] : null,
                'EVENT_BUS_SYNC_API_URL' => isset($this->configuration['EVENT_BUS_SYNC_API_URL']) ? $this->configuration['EVENT_BUS_SYNC_API_URL'] : null,
            ],
        ];
    }

    /**
     * @return mixed
     */
    private function getAccountsClient()
    {
        $module = \Module::getInstanceByName('ps_accounts');

        /* @phpstan-ignore-next-line */
        return $module->getService(AccountsClient::class);
    }
}
