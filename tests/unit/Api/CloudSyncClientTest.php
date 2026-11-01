<?php

namespace PrestaShop\Module\PsEventbus\Tests\Api;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Api\CloudSyncClient;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;

class CloudSyncClientTest extends TestCase
{
    /**
     * Nothing listens there: requests are refused at once, without leaving the machine.
     */
    const CLOSED_PORT_URL = 'http://127.0.0.1:9';

    public function testDoesNotReadTheAccountsCredentialsWhenBuilt()
    {
        $psAccountsAdapterService = $this->createMock(PsAccountsAdapterService::class);
        $psAccountsAdapterService->expects($this->never())->method('getShopToken');
        $psAccountsAdapterService->expects($this->never())->method('getShopUuid');

        $this->createClient($psAccountsAdapterService);
    }

    public function testReadsTheAccountsCredentialsOnceForSeveralCloudSyncCalls()
    {
        $psAccountsAdapterService = $this->createMock(PsAccountsAdapterService::class);
        $psAccountsAdapterService->expects($this->once())->method('getShopToken')->willReturn('shop-token');
        $psAccountsAdapterService->expects($this->once())->method('getShopUuid')->willReturn('shop-uuid');
        $client = $this->createClient($psAccountsAdapterService);

        $this->assertFalse($client->validateJobId('job-id')['status']);
        $this->assertFalse($client->liveSync('products', 'upsert')['status']);
    }

    public function testDoesNotReadTheAccountsCredentialsAgainWhenTheyAreEmpty()
    {
        $psAccountsAdapterService = $this->createMock(PsAccountsAdapterService::class);
        $psAccountsAdapterService->expects($this->once())->method('getShopToken')->willReturn(null);
        $psAccountsAdapterService->expects($this->once())->method('getShopUuid')->willReturn('');
        $client = $this->createClient($psAccountsAdapterService);

        $client->liveSync('products', 'upsert');
        $client->liveSync('categories', 'upsert');
    }

    /**
     * @param PsAccountsAdapterService $psAccountsAdapterService
     *
     * @return CloudSyncClient
     */
    private function createClient(PsAccountsAdapterService $psAccountsAdapterService)
    {
        return new CloudSyncClient(
            self::CLOSED_PORT_URL,
            self::CLOSED_PORT_URL,
            self::CLOSED_PORT_URL,
            $this->createMock(\Ps_eventbus::class),
            $psAccountsAdapterService
        );
    }
}
