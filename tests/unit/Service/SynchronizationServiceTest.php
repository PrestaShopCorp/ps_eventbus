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
use PrestaShop\Module\PsEventbus\Service\ShopContent\ShopContentServiceInterface;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;

require_once __DIR__ . '/../Stub/PrestaShopDoubles.php';

class SynchronizationServiceTest extends TestCase
{
    /**
     * @var array<string, string[]> languages whose outbox is over the size limit, per content type
     */
    private $oversizedLangIsos = [];

    /**
     * @var array<string, bool> full sync state per "type|lang" pair of the current shop
     */
    private $fullSyncDone = [];

    /**
     * @var array<int, array<string, mixed>>
     */
    private $insertedRows = [];

    /**
     * @var string[] calls that change the full sync state or purge the outbox, in order
     */
    private $syncStateCalls = [];

    /**
     * @var string|null cursor a full sync page is read from
     */
    private $lastSeekKey;

    /**
     * @var array<string, int> rows left after a seek key ("" for the start)
     */
    private $contentLeft = [];

    /**
     * @var int HTTP status of the upload
     */
    private $uploadHttpCode = 201;

    /**
     * @var bool whether moveFullSyncCursor() finds the cursor where the page was read from
     */
    private $cursorStillThere = true;

    /**
     * @var array<int, array<int, mixed>> arguments of each moveFullSyncCursor() call
     */
    private $cursorMoves = [];

    public function testRecordsTheEventWhenTheSizeCheckRunsOnASmallOutbox()
    {
        $this->fullSyncDone = ['specific_prices|en' => true];

        $this->insertWhileTheSizeCheckRuns([Config::COLLECTION_SPECIFIC_PRICES => 42]);

        $this->assertSame([], $this->syncStateCalls);
        $this->assertSame([['specific_prices', 42, 'en']], $this->insertedTypeIdsAndLangs());
    }

    public function testRecordsEveryContentTypeOfTheEventWhenTheSizeCheckRuns()
    {
        $this->fullSyncDone = ['carts|en' => true, 'cart_products|en' => true];

        $this->insertWhileTheSizeCheckRuns([Config::COLLECTION_CARTS => 7, Config::COLLECTION_CART_PRODUCTS => 7]);

        $this->assertSame([['carts', 7, 'en'], ['cart_products', 7, 'en']], $this->insertedTypeIdsAndLangs());
    }

    public function testPurgesThenRestartsAnOversizedPairAndLeavesTheOthersAlone()
    {
        $this->fullSyncDone = ['carts|en' => true, 'carts|fr' => true, 'cart_products|en' => true, 'cart_products|fr' => true];
        $this->oversizedLangIsos = [Config::COLLECTION_CARTS => ['fr']];

        $this->insertWhileTheSizeCheckRuns([Config::COLLECTION_CARTS => 7, Config::COLLECTION_CART_PRODUCTS => 7], true);

        $this->assertSame(
            ['purge carts fr', 'restart carts fr'],
            $this->syncStateCalls,
            'The outbox of the pair must be purged before its full sync restarts: rows recorded in between are kept'
        );
        $this->assertSame(
            [['carts', 7, 'en'], ['cart_products', 7, 'en'], ['cart_products', 7, 'fr']],
            $this->insertedTypeIdsAndLangs()
        );
    }

    public function testChecksTheSizeOfEveryContentTypeOfTheEvent()
    {
        $this->fullSyncDone = ['carts|en' => true, 'cart_products|en' => true];
        $this->oversizedLangIsos = [Config::COLLECTION_CART_PRODUCTS => ['en']];

        $this->insertWhileTheSizeCheckRuns([Config::COLLECTION_CARTS => 7, Config::COLLECTION_CART_PRODUCTS => 7]);

        $this->assertSame(['purge cart_products en', 'restart cart_products en'], $this->syncStateCalls);
        $this->assertSame([['carts', 7, 'en']], $this->insertedTypeIdsAndLangs());
    }

    public function testMovesTheFullSyncCursorFromTheKeyThePageWasReadFrom()
    {
        $this->lastSeekKey = '42-0';
        $this->contentLeft = ['50-0' => 10];

        $response = $this->sendFullSyncPage();

        $this->assertSame([['products', 'en', '42-0', '50-0', false, '2026-11-01 12:00:00']], $this->cursorMoves);
        $this->assertTrue($response['has_remaining_objects']);
        $this->assertSame(10, $response['remaining_objects']);
    }

    public function testKeepsTheFullSyncCursorWhenTheUploadFails()
    {
        $this->lastSeekKey = '42-0';
        $this->contentLeft = ['50-0' => 10];
        $this->uploadHttpCode = 500;

        $this->sendFullSyncPage();

        $this->assertSame([['products', 'en', '42-0', '42-0', false, '2026-11-01 12:00:00']], $this->cursorMoves);
    }

    public function testReportsTheRestartedFullSyncWhenItRestartedDuringTheLastPage()
    {
        $this->lastSeekKey = '42-0';
        $this->contentLeft = ['50-0' => 0, '' => 300];
        $this->cursorStillThere = false;

        $response = $this->sendFullSyncPage();

        $this->assertSame([['products', 'en', '42-0', null, true, '2026-11-01 12:00:00']], $this->cursorMoves);
        $this->assertTrue(
            $response['has_remaining_objects'],
            'CloudSync must ask for the next page of the restarted full sync instead of closing the job'
        );
        $this->assertSame(300, $response['remaining_objects']);
    }

    /**
     * Runs insertContentIntoIncremental() on a call sampled for the outbox size check.
     *
     * @param array<string, mixed> $contentTypesWithIds
     * @param bool $hasMultiLang
     */
    private function insertWhileTheSizeCheckRuns(array $contentTypesWithIds, $hasMultiLang = false)
    {
        $this->createService()->insertContentIntoIncremental(
            $contentTypesWithIds,
            Config::INCREMENTAL_TYPE_UPSERT,
            '2026-11-01 12:00:00',
            1,
            $hasMultiLang
        );
    }

    /**
     * Sends one products full sync page of one row ending at "50-0".
     *
     * @return array<mixed>
     */
    private function sendFullSyncPage()
    {
        return $this->createService()->sendFullSync('products', 'job-id', 'en', 50, time(), '2026-11-01 12:00:00');
    }

    /**
     * @return array<int, array{0: string, 1: mixed, 2: string}>
     */
    private function insertedTypeIdsAndLangs()
    {
        return array_map(function (array $row) {
            return [$row['type'], $row['id_object'], $row['lang_iso']];
        }, $this->insertedRows);
    }

    private function createService()
    {
        $syncRepository = $this->createMock(SyncRepository::class);
        $syncRepository->method('isFullSyncDoneForThisTypeSync')->willReturnCallback(function ($type, $langIso) {
            return !empty($this->fullSyncDone[$type . '|' . $langIso]);
        });
        $syncRepository->method('getLastSeekKey')->willReturnCallback(function () {
            return $this->lastSeekKey;
        });
        $syncRepository->method('upsertTypeSync')->willReturnCallback(function ($type, $lastSeekKey, $date, $fullSyncFinished, $langIso) {
            $this->syncStateCalls[] = ($fullSyncFinished ? 'finish ' : 'restart ') . $type . ' ' . $langIso;
            $this->fullSyncDone[$type . '|' . $langIso] = (bool) $fullSyncFinished;

            return true;
        });
        $syncRepository->method('moveFullSyncCursor')->willReturnCallback(function () {
            $this->cursorMoves[] = func_get_args();

            return $this->cursorStillThere;
        });

        $incrementalSyncRepository = $this->createMock(IncrementalSyncRepository::class);
        $incrementalSyncRepository->method('getLangIsosOverSizeForCurrentShop')->willReturnCallback(function ($type, $maxSize) {
            return isset($this->oversizedLangIsos[$type]) ? $this->oversizedLangIsos[$type] : [];
        });
        $incrementalSyncRepository->method('removeIncrementalSyncObjectsForCurrentShop')->willReturnCallback(function ($type, $langIso) {
            $this->syncStateCalls[] = 'purge ' . $type . ' ' . $langIso;

            return true;
        });
        $incrementalSyncRepository->method('insertIncrementalObject')->willReturnCallback(function (array $rows) {
            $this->insertedRows = array_merge($this->insertedRows, $rows);
        });
        $incrementalSyncRepository->method('getRemainingIncrementalObjects')->willReturn(0);

        $languagesService = $this->createMock(LanguagesService::class);
        $languagesService->method('getDefaultLanguageIsoCode')->willReturn('en');
        $languagesService->method('getLanguagesIsoCodes')->willReturn(['en', 'fr']);

        $cloudSyncClient = $this->createMock(CloudSyncClient::class);
        $cloudSyncClient->method('upload')->willReturnCallback(function () {
            return ['status' => $this->uploadHttpCode === 201, 'httpCode' => $this->uploadHttpCode];
        });

        $shopContentService = $this->createMock(ShopContentServiceInterface::class);
        $shopContentService->method('getContentsForFull')->willReturn(['rows' => [['id' => '50-0']], 'lastSeekKey' => '50-0']);
        $shopContentService->method('getFullSyncContentLeft')->willReturnCallback(function ($seekKey) {
            return isset($this->contentLeft[(string) $seekKey]) ? $this->contentLeft[(string) $seekKey] : 0;
        });

        $service = $this->getMockBuilder(SynchronizationService::class)
            ->setConstructorArgs([
                $cloudSyncClient,
                $syncRepository,
                $incrementalSyncRepository,
                $this->createMock(LiveSyncRepository::class),
                $languagesService,
                $this->createMock(ErrorHandler::class),
            ])
            ->onlyMethods(['shouldCheckOutboxSize', 'getShopContentService'])
            ->getMock();
        $service->method('shouldCheckOutboxSize')->willReturn(true);
        $service->method('getShopContentService')->willReturn($shopContentService);

        return $service;
    }
}
