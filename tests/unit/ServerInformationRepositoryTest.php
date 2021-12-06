<?php

use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;
use PrestaShop\Module\PsEventbus\Repository\CurrencyRepository;
use PrestaShop\Module\PsEventbus\Repository\LanguageRepository;
use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;
use PrestaShop\Module\PsEventbus\Repository\ShopRepository;
use PrestaShop\Module\PsEventbus\Tests\Mocks\Handler\ErrorHandlerMock;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("repository")
 * @Stories("server information repository")
 */
class ServerInformationRepositoryTest extends BaseTestCase
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
     * @var ServerInformationRepository
     */
    private $serverInformationRepository;
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;
    /**
     * @var ShopRepository
     */
    private $shopRepository;
    /**
     * @var ArrayFormatter
     */
    private $arrayFormatter;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var Db
     */
    private $db;
    /**
     * @var PsAccounts
     */
    private $psAccounts;

    public function setUp()
    {
        parent::setUp();
        $this->currencyRepository = $this->createMock(CurrencyRepository::class);
        $this->languageRepository = $this->createMock(LanguageRepository::class);
        $this->configurationRepository = $this->createMock(ConfigurationRepository::class);
        $this->shopRepository = $this->createMock(ShopRepository::class);
        $this->arrayFormatter = $this->createMock(ArrayFormatter::class);
        $this->psAccounts = $this->createMock(PsAccounts::class);
        $this->arrayFormatter = $this->createMock(ArrayFormatter::class);
        $this->context = $this->createMock(Context::class);
        $link = $this->createMock(Link::class);
        $this->context->link = $link;
        $this->db = $this->createMock(Db::class);

        $this->serverInformationRepository = new ServerInformationRepository(
            $this->context,
            $this->db,
            $this->currencyRepository,
            $this->languageRepository,
            $this->configurationRepository,
            $this->shopRepository,
            $this->arrayFormatter,
            $this->psAccounts,
            new ErrorHandlerMock(),
            []
        );
    }

    /**
     * @Stories("server information repository")
     * @Title("testGetServerInformation")
     */
    public function testGetServerInformation()
    {
        $this->shopRepository->method('getMultiShopCount')->willReturn(1);
        $this->currencyRepository->method('getCurrenciesIsoCodes')->willReturn(['EUR', 'USD']);
        $this->currencyRepository->method('getDefaultCurrencyIsoCode')->willReturn('USD');

        $this->languageRepository->method('getLanguagesIsoCodes')->willReturn(['en', 'fr', 'lt']);
        $this->languageRepository->method('getDefaultLanguageIsoCode')->willReturn('en');

        $this->configurationRepository->expects($this->at(0))->method('get')->with('PS_REWRITING_SETTINGS')->willReturn(true);
        $this->configurationRepository->expects($this->at(1))->method('get')->with('PS_CART_FOLLOWING')->willReturn(true);
        $this->configurationRepository->expects($this->at(2))->method('get')->with('PS_WEIGHT_UNIT')->willReturn('kg');
        $this->configurationRepository->expects($this->at(3))->method('get')->with('PS_BASE_DISTANCE_UNIT')->willReturn('km');
        $this->configurationRepository->expects($this->at(4))->method('get')->with('PS_VOLUME_UNIT')->willReturn('L');
        $this->configurationRepository->expects($this->at(5))->method('get')->with('PS_DIMENSION_UNIT')->willReturn('cm');
        $this->configurationRepository->expects($this->at(6))->method('get')->with('PS_TIMEZONE')->willReturn('GMT/Zulu');
        $this->configurationRepository->expects($this->at(7))->method('get')->with('PS_ORDER_RETURN')->willReturn('1');
        $this->configurationRepository->expects($this->at(8))->method('get')->with('PS_ORDER_RETURN_NB_DAYS')->willReturn('1');

        $this->context->link->method('getPageLink')->willReturn('some link');

        $this->assertTrue(is_array($this->serverInformationRepository->getServerInformation()));
    }
}
