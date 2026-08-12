<?php

namespace PrestaShop\Module\PsEventbus\Tests\Service;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Api\CloudSyncClient;
use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;
use PrestaShop\Module\PsEventbus\Service\ConnectionsService;

class ConnectionsServiceTest extends TestCase
{
    const MODULES_BASE_URL = 'https://shop.example.com/modules/';

    /**
     * @param array<mixed> $items
     * @param array<string, string> $installedModules moduleName => displayName
     *
     * @return ConnectionsService
     */
    private function buildService(array $items, array $installedModules = [])
    {
        $client = $this->createMock(CloudSyncClient::class);
        $client->method('getShopConsents')->willReturn($items);

        $moduleHelper = $this->createMock(ModuleHelper::class);
        $moduleHelper->method('getInstanceByName')->willReturnCallback(
            function ($moduleName) use ($installedModules) {
                if (!isset($installedModules[$moduleName])) {
                    return false;
                }

                $module = new \stdClass();
                $module->displayName = $installedModules[$moduleName];

                return $module;
            }
        );

        return new ConnectionsService($client, $moduleHelper, self::MODULES_BASE_URL);
    }

    public function testInstalledModuleExposesItsDisplayNameAndLogo()
    {
        $service = $this->buildService(
            [['moduleName' => 'psmarketingwithgoogle', 'consents' => ['info'], 'revokedAt' => null]],
            ['psmarketingwithgoogle' => 'PS Marketing with Google']
        );

        $services = $service->getConnections();

        $this->assertCount(1, $services);
        $this->assertSame('psmarketingwithgoogle', $services[0]['moduleName']);
        $this->assertSame('PS Marketing with Google', $services[0]['displayName']);
        $this->assertSame(self::MODULES_BASE_URL . 'psmarketingwithgoogle/logo.png', $services[0]['logoUrl']);
        $this->assertSame(['info'], $services[0]['consents']);
        $this->assertNull($services[0]['revokedAt']);
    }

    public function testMissingModuleFallsBackToItsRawName()
    {
        $service = $this->buildService(
            [['moduleName' => 'creativenews', 'consents' => [], 'revokedAt' => '2023-08-22T09:14:00.000Z']]
        );

        $services = $service->getConnections();

        $this->assertSame('creativenews', $services[0]['displayName']);
        $this->assertNull($services[0]['logoUrl']);
        $this->assertSame('2023-08-22T09:14:00.000Z', $services[0]['revokedAt']);
    }

    public function testActiveServicesComeFirstThenAlphabeticalOrder()
    {
        $service = $this->buildService(
            [
                ['moduleName' => 'zeta', 'consents' => [], 'revokedAt' => null],
                ['moduleName' => 'revoked_one', 'consents' => [], 'revokedAt' => '2023-08-22T09:14:00.000Z'],
                ['moduleName' => 'alpha', 'consents' => [], 'revokedAt' => null],
                ['moduleName' => 'another_revoked', 'consents' => [], 'revokedAt' => '2024-01-01T00:00:00.000Z'],
            ]
        );

        $names = array_column($service->getConnections(), 'moduleName');

        $this->assertSame(['alpha', 'zeta', 'another_revoked', 'revoked_one'], $names);
    }

    public function testEmptyResponseYieldsAnEmptyListWithoutError()
    {
        $this->assertSame([], $this->buildService([])->getConnections());
    }

    public function testMalformedEntriesAreSkipped()
    {
        $service = $this->buildService([
            ['consents' => ['info']],
            ['moduleName' => 'valid', 'consents' => ['info'], 'revokedAt' => null],
        ]);

        $services = $service->getConnections();

        $this->assertCount(1, $services);
        $this->assertSame('valid', $services[0]['moduleName']);
    }

    public function testClientFailurePropagates()
    {
        $client = $this->createMock(CloudSyncClient::class);
        $client->method('getShopConsents')->willThrowException(new \Exception('boom'));

        $service = new ConnectionsService($client, $this->createMock(ModuleHelper::class), self::MODULES_BASE_URL);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('boom');

        $service->getConnections();
    }
}
