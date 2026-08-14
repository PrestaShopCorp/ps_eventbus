<?php

namespace PrestaShop\Module\PsEventbus\Tests\Service;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;
use PrestaShop\Module\PsEventbus\Helper\NetworkProbe;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use PrestaShop\Module\PsEventbus\Service\SystemDiagnosticService;

class SystemDiagnosticServiceTest extends TestCase
{
    const PROXY_URL = 'https://eventbus-proxy.example.net';
    const SYNC_URL = 'https://eventbus-sync.example.net';
    const LIVE_SYNC_URL = 'https://api.example.com/live-sync/v1';
    const CLOUD_API_URL = 'https://api.example.com/sync/v1';
    const SHOP_DOMAIN = 'myshop.example.com';

    const REACHABLE = ['reachable' => true, 'httpStatus' => 200, 'error' => null];
    const VALID_CERTIFICATE = ['valid' => true, 'expiresAt' => '2030-01-01T00:00:00+00:00', 'error' => null];

    /**
     * @param array<string, string> $installedModules moduleName => version
     * @param array<string, mixed>|null $ping
     * @param array<string, mixed>|null $certificate
     * @param bool $sslEnabled
     *
     * @return SystemDiagnosticService
     */
    private function buildService(
        array $installedModules = [],
        $ping = null,
        $certificate = null,
        $sslEnabled = true
    ) {
        $moduleHelper = $this->createMock(ModuleHelper::class);
        $moduleHelper->method('isInstalled')->willReturnCallback(
            function ($moduleName) use ($installedModules) {
                return isset($installedModules[$moduleName]);
            }
        );
        $moduleHelper->method('getInstanceByName')->willReturnCallback(
            function ($moduleName) use ($installedModules) {
                if (!isset($installedModules[$moduleName])) {
                    return false;
                }

                $module = new \stdClass();
                $module->version = $installedModules[$moduleName];

                return $module;
            }
        );

        $networkProbe = $this->createMock(NetworkProbe::class);
        $networkProbe->method('ping')->willReturn($ping === null ? self::REACHABLE : $ping);
        $networkProbe->method('inspectCertificate')->willReturn($certificate === null ? self::VALID_CERTIFICATE : $certificate);

        $psAccounts = $this->createMock(PsAccountsAdapterService::class);
        $psAccounts->method('getShopUrl')->willReturn('https://myshop.example.com');
        $psAccounts->method('getShopUuid')->willReturn('shop-uuid');

        return new SystemDiagnosticService(
            $psAccounts,
            $moduleHelper,
            $networkProbe,
            $this->createMock(ErrorHandler::class),
            self::PROXY_URL,
            self::SYNC_URL,
            self::LIVE_SYNC_URL,
            self::CLOUD_API_URL,
            self::SHOP_DOMAIN,
            $sslEnabled
        );
    }

    public function testRequiredModulesAreAlwaysReportedEvenWhenAbsent()
    {
        $diagnostic = $this->buildService(['ps_eventbus' => '4.2.1'])->getDiagnostic();

        $modules = array_column($diagnostic['modules'], 'version', 'id');

        $this->assertSame('4.2.1', $modules['ps_eventbus']);
        $this->assertArrayHasKey('ps_accounts', $modules);
        $this->assertNull($modules['ps_accounts']);
    }

    public function testPartnerModulesAreOmittedWhenNotInstalled()
    {
        $diagnostic = $this->buildService(['ps_eventbus' => '4.2.1', 'ps_metrics' => '3.6.3'])->getDiagnostic();

        $ids = array_column($diagnostic['modules'], 'id');

        $this->assertContains('ps_metrics', $ids);
        $this->assertNotContains('ps_facebook', $ids);
        $this->assertNotContains('psmarketingwithgoogle', $ids);
    }

    public function testModulesKeepTheDisplayOrderOfThePage()
    {
        $diagnostic = $this->buildService([
            'ps_metrics' => '3.6.3',
            'ps_facebook' => '1.29.0',
            'ps_eventbus' => '4.2.1',
            'psmarketingwithgoogle' => '1.57.0',
            'ps_accounts' => '5.4.8',
        ])->getDiagnostic();

        $this->assertSame(
            ['ps_eventbus', 'ps_accounts', 'psmarketingwithgoogle', 'ps_facebook', 'ps_metrics'],
            array_column($diagnostic['modules'], 'id')
        );
    }

    public function testEnvironmentUrlsAreReportedAsConfigured()
    {
        $diagnostic = $this->buildService()->getDiagnostic();

        $this->assertSame(self::PROXY_URL, $diagnostic['env']['EVENT_BUS_PROXY_API_URL']);
        $this->assertSame(self::SYNC_URL, $diagnostic['env']['EVENT_BUS_SYNC_API_URL']);
        $this->assertSame(self::LIVE_SYNC_URL, $diagnostic['env']['EVENT_BUS_LIVE_SYNC_API_URL']);
    }

    public function testCloudApiFailureIsReportedWithoutThrowing()
    {
        $diagnostic = $this->buildService(
            [],
            ['reachable' => false, 'httpStatus' => null, 'error' => 'Connection timed out']
        )->getDiagnostic();

        $this->assertFalse($diagnostic['cloudApi']['reachable']);
        $this->assertSame('Connection timed out', $diagnostic['cloudApi']['error']);
        $this->assertSame(self::CLOUD_API_URL, $diagnostic['cloudApi']['url']);
    }

    public function testExpiredCertificateIsReportedInvalid()
    {
        $diagnostic = $this->buildService(
            [],
            null,
            ['valid' => false, 'expiresAt' => '2020-01-01T00:00:00+00:00', 'error' => 'Certificate has expired']
        )->getDiagnostic();

        $this->assertTrue($diagnostic['ssl']['https']);
        $this->assertFalse($diagnostic['ssl']['valid']);
        $this->assertSame('Certificate has expired', $diagnostic['ssl']['error']);
    }

    public function testUndeterminedCertificateIsNeitherValidNorInvalid()
    {
        $diagnostic = $this->buildService(
            [],
            null,
            ['valid' => null, 'expiresAt' => null, 'error' => 'No certificate was presented']
        )->getDiagnostic();

        $this->assertNull($diagnostic['ssl']['valid']);
    }

    public function testShopWithoutSslSkipsTheCertificateCheck()
    {
        $networkProbe = $this->createMock(NetworkProbe::class);
        $networkProbe->method('ping')->willReturn(self::REACHABLE);
        $networkProbe->expects($this->never())->method('inspectCertificate');

        $service = new SystemDiagnosticService(
            $this->createMock(PsAccountsAdapterService::class),
            $this->createMock(ModuleHelper::class),
            $networkProbe,
            $this->createMock(ErrorHandler::class),
            self::PROXY_URL,
            self::SYNC_URL,
            self::LIVE_SYNC_URL,
            self::CLOUD_API_URL,
            self::SHOP_DOMAIN,
            false
        );

        $ssl = $service->getDiagnostic()['ssl'];

        $this->assertFalse($ssl['https']);
        $this->assertNull($ssl['valid']);
    }

    public function testPhpAndPrestashopVersionsAreReported()
    {
        $diagnostic = $this->buildService()->getDiagnostic();

        $this->assertSame(_PS_VERSION_, $diagnostic['prestashopVersion']);
        $this->assertMatchesRegularExpression('/^\d+\.\d+/', $diagnostic['phpVersion']);
        $this->assertTrue($diagnostic['phpCompatible']);
    }

    public function testAccountValuesFallBackToNullRatherThanFailing()
    {
        $psAccounts = $this->createMock(PsAccountsAdapterService::class);
        $psAccounts->method('getShopUrl')->willThrowException(new \Exception('ps_accounts is broken'));
        // What ps_accounts actually returns on an unlinked shop, despite the
        // adapter annotating a string
        $psAccounts->method('getShopUuid')->willReturn(false);

        $networkProbe = $this->createMock(NetworkProbe::class);
        $networkProbe->method('ping')->willReturn(self::REACHABLE);
        $networkProbe->method('inspectCertificate')->willReturn(self::VALID_CERTIFICATE);

        $service = new SystemDiagnosticService(
            $psAccounts,
            $this->createMock(ModuleHelper::class),
            $networkProbe,
            $this->createMock(ErrorHandler::class),
            self::PROXY_URL,
            self::SYNC_URL,
            self::LIVE_SYNC_URL,
            self::CLOUD_API_URL,
            self::SHOP_DOMAIN,
            true
        );

        $diagnostic = $service->getDiagnostic();

        $this->assertNull($diagnostic['accountsShopUrl']);
        $this->assertNull($diagnostic['shopId']);
    }
}
