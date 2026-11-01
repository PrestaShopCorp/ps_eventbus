<?php

namespace PrestaShop\Module\PsEventbus\Tests\Service;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Api\CloudSyncClient;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\LiveSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\SyncRepository;
use PrestaShop\Module\PsEventbus\Service\ShopContent\LanguagesService;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;

class SynchronizationServiceTest extends TestCase
{
    /**
     * @var array<string, int> outbox row count per content type
     */
    private $outboxCount = [];

    /**
     * @var array<string, bool> full sync state per content type
     */
    private $fullSyncDone = [];

    /**
     * @var array<int, array<string, mixed>>
     */
    private $insertedRows = [];

    /**
     * @var string[]
     */
    private $purgedTypes = [];

    public function testRecordsTheEventWhenTheSizeCheckRunsOnASmallOutbox()
    {
        $this->fullSyncDone = [Config::COLLECTION_SPECIFIC_PRICES => true];
        $this->outboxCount = [Config::COLLECTION_SPECIFIC_PRICES => 10];

        $this->insertWhileTheSizeCheckRuns([Config::COLLECTION_SPECIFIC_PRICES => 42]);

        $this->assertSame([], $this->purgedTypes);
        $this->assertSame([[Config::COLLECTION_SPECIFIC_PRICES, 42]], $this->insertedTypesAndIds());
    }

    public function testRecordsEveryContentTypeOfTheEventWhenTheSizeCheckRuns()
    {
        $this->fullSyncDone = [Config::COLLECTION_CARTS => true, Config::COLLECTION_CART_PRODUCTS => true];
        $this->outboxCount = [Config::COLLECTION_CARTS => 10, Config::COLLECTION_CART_PRODUCTS => 10];

        $this->insertWhileTheSizeCheckRuns([Config::COLLECTION_CARTS => 7, Config::COLLECTION_CART_PRODUCTS => 7]);

        $this->assertSame(
            [[Config::COLLECTION_CARTS, 7], [Config::COLLECTION_CART_PRODUCTS, 7]],
            $this->insertedTypesAndIds()
        );
    }

    public function testPurgesAnOversizedOutboxAndLeavesItsTypeToTheNextFullSync()
    {
        $this->fullSyncDone = [Config::COLLECTION_CARTS => true, Config::COLLECTION_CART_PRODUCTS => true];
        $this->outboxCount = [
            Config::COLLECTION_CARTS => Config::INCREMENTAL_SYNC_MAX_TABLE_SIZE + 1,
            Config::COLLECTION_CART_PRODUCTS => 10,
        ];

        $this->insertWhileTheSizeCheckRuns([Config::COLLECTION_CARTS => 7, Config::COLLECTION_CART_PRODUCTS => 7]);

        $this->assertSame([Config::COLLECTION_CARTS], $this->purgedTypes);
        $this->assertFalse($this->fullSyncDone[Config::COLLECTION_CARTS]);
        $this->assertSame([[Config::COLLECTION_CART_PRODUCTS, 7]], $this->insertedTypesAndIds());
    }

    public function testOnlyChecksTheSizeOfTheFirstContentType()
    {
        $this->fullSyncDone = [Config::COLLECTION_CARTS => true, Config::COLLECTION_CART_PRODUCTS => true];
        $this->outboxCount = [
            Config::COLLECTION_CARTS => 10,
            Config::COLLECTION_CART_PRODUCTS => Config::INCREMENTAL_SYNC_MAX_TABLE_SIZE + 1,
        ];

        $this->insertWhileTheSizeCheckRuns([Config::COLLECTION_CARTS => 7, Config::COLLECTION_CART_PRODUCTS => 7]);

        $this->assertSame([], $this->purgedTypes);
        $this->assertSame(
            [[Config::COLLECTION_CARTS, 7], [Config::COLLECTION_CART_PRODUCTS, 7]],
            $this->insertedTypesAndIds()
        );
    }

    /**
     * Runs insertContentIntoIncremental() with mt_rand() seeded so that the outbox size check runs.
     * The service is built first: creating mocks consumes mt_rand() values.
     *
     * @param array<string, mixed> $contentTypesWithIds
     */
    private function insertWhileTheSizeCheckRuns(array $contentTypesWithIds)
    {
        $service = $this->createService();

        for ($seed = 0;; ++$seed) {
            mt_srand($seed);
            if (mt_rand() % Config::INCREMENTAL_SYNC_TABLE_SIZE_CHECK_MOD == 0) {
                break;
            }
        }

        mt_srand($seed);
        try {
            $service->insertContentIntoIncremental(
                $contentTypesWithIds,
                Config::INCREMENTAL_TYPE_UPSERT,
                '2026-11-01 12:00:00',
                1,
                false
            );
        } finally {
            mt_srand();
        }
    }

    /**
     * @return array<int, array{0: string, 1: mixed}>
     */
    private function insertedTypesAndIds()
    {
        return array_map(function (array $row) {
            return [$row['type'], $row['id_object']];
        }, $this->insertedRows);
    }

    private function createService()
    {
        $syncRepository = $this->createMock(SyncRepository::class);
        $syncRepository->method('isFullSyncDoneForThisTypeSync')->willReturnCallback(function ($type) {
            return !empty($this->fullSyncDone[$type]);
        });
        $syncRepository->method('getLastSeekKey')->willReturn(null);
        $syncRepository->method('upsertTypeSync')->willReturnCallback(function ($type, $lastSeekKey, $date, $fullSyncFinished) {
            $this->fullSyncDone[$type] = (bool) $fullSyncFinished;

            return true;
        });

        $incrementalSyncRepository = $this->createMock(IncrementalSyncRepository::class);
        $incrementalSyncRepository->method('getIncrementalSyncObjectCountByType')->willReturnCallback(function ($type) {
            return isset($this->outboxCount[$type]) ? $this->outboxCount[$type] : 0;
        });
        $incrementalSyncRepository->method('removeIncrementaSyncObjectByType')->willReturnCallback(function ($type) {
            $this->purgedTypes[] = $type;

            return true;
        });
        $incrementalSyncRepository->method('insertIncrementalObject')->willReturnCallback(function (array $rows) {
            $this->insertedRows = array_merge($this->insertedRows, $rows);
        });

        $languagesService = $this->createMock(LanguagesService::class);
        $languagesService->method('getDefaultLanguageIsoCode')->willReturn('en');
        $languagesService->method('getLanguagesIsoCodes')->willReturn(['en']);

        return new SynchronizationService(
            $this->createMock(CloudSyncClient::class),
            $syncRepository,
            $incrementalSyncRepository,
            $this->createMock(LiveSyncRepository::class),
            $languagesService,
            $this->createMock(ErrorHandler::class)
        );
    }
}
