<?php

namespace PrestaShop\Module\PsEventbus\Tests\Repository;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Repository\AbstractRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\SyncRepository;

require_once __DIR__ . '/../Stub/PrestaShopDoubles.php';

class OutboxPurgeSqlTest extends TestCase
{
    public function testFindsTheOversizedLanguagesOfTheCurrentShopOnly()
    {
        $db = new \Db();
        $db->rows = [['lang_iso' => 'fr']];
        $repository = $this->createRepository(IncrementalSyncRepository::class, $db, 2);

        $this->assertSame(['fr'], $repository->getLangIsosOverSizeForCurrentShop('carts', 1000000));
        $this->assertSame(
            ['SELECT eis.lang_iso FROM `ps_eventbus_incremental_sync` eis WHERE eis.type = "carts" AND eis.id_shop = 2'
                . ' GROUP BY eis.lang_iso HAVING COUNT(*) > 1000000'],
            array_map([$this, 'normalize'], $db->executed)
        );
    }

    public function testRemovesTheOutboxRowsOfTheCurrentShopAndLanguageOnly()
    {
        $db = new \Db();
        $repository = $this->createRepository(IncrementalSyncRepository::class, $db, 2);

        $repository->removeIncrementalSyncObjectsForCurrentShop('carts', 'fr');

        $this->assertCount(1, $db->deleted);
        $this->assertSame('eventbus_incremental_sync', $db->deleted[0][0]);
        $this->assertSame(
            'type = "carts" AND id_shop = 2 AND lang_iso = "fr"',
            $this->normalize($db->deleted[0][1])
        );
    }

    public function testMovesTheFullSyncCursorOnlyFromTheKeyThePageWasReadFrom()
    {
        $db = new \Db();
        $db->row = ['last_seek_key' => '50-0', 'full_sync_finished' => '0'];
        $repository = $this->createRepository(SyncRepository::class, $db, 1);

        $this->assertTrue($repository->moveFullSyncCursor('products', 'en', '42-0', '50-0', false, '2026-11-01 12:00:00'));
        $this->assertSame(
            [
                'UPDATE `ps_eventbus_type_sync` SET last_seek_key = "50-0", full_sync_finished = 0,'
                    . ' last_sync_date = "2026-11-01 12:00:00" WHERE type = "products" AND id_shop = 1 AND lang_iso = "en"'
                    . ' AND full_sync_finished = 0 AND last_seek_key = "42-0"',
                'SELECT last_seek_key, full_sync_finished FROM `ps_eventbus_type_sync`'
                    . ' WHERE type = "products" AND id_shop = 1 AND lang_iso = "en"',
            ],
            array_map([$this, 'normalize'], $db->executed)
        );
    }

    public function testMovesTheFullSyncCursorFromTheStartAndFinishesIt()
    {
        $db = new \Db();
        $db->row = ['last_seek_key' => null, 'full_sync_finished' => '1'];
        $repository = $this->createRepository(SyncRepository::class, $db, 1);

        $this->assertTrue($repository->moveFullSyncCursor('products', 'en', null, null, true, '2026-11-01 12:00:00'));
        $this->assertSame(
            'UPDATE `ps_eventbus_type_sync` SET last_seek_key = NULL, full_sync_finished = 1,'
                . ' last_sync_date = "2026-11-01 12:00:00" WHERE type = "products" AND id_shop = 1 AND lang_iso = "en"'
                . ' AND full_sync_finished = 0 AND (last_seek_key IS NULL OR last_seek_key = "")',
            $this->normalize($db->executed[0])
        );
    }

    public function testTellsWhenTheFullSyncWasRestartedBeforeTheCursorCouldMove()
    {
        $db = new \Db();
        // a purge restarted the full sync: the update matched nothing, the cursor is back at the start
        $db->row = ['last_seek_key' => '', 'full_sync_finished' => '0'];
        $repository = $this->createRepository(SyncRepository::class, $db, 1);

        $this->assertFalse($repository->moveFullSyncCursor('products', 'en', '42-0', '50-0', false, '2026-11-01 12:00:00'));
    }

    public function testTellsTheCursorMovedWhenTheUpdateWroteTheSameValues()
    {
        $db = new \Db();
        // a failed upload keeps the cursor: the update writes what is already there and affects no row
        $db->row = ['last_seek_key' => '42-0', 'full_sync_finished' => '0'];
        $repository = $this->createRepository(SyncRepository::class, $db, 1);

        $this->assertTrue($repository->moveFullSyncCursor('products', 'en', '42-0', '42-0', false, '2026-11-01 12:00:00'));
    }

    /**
     * @param string $class
     * @param \Db $db
     * @param int $shopId
     *
     * @return mixed
     */
    private function createRepository($class, \Db $db, $shopId)
    {
        $shop = new \Shop();
        $shop->id = $shopId;
        $context = new \Context();
        $context->shop = $shop;

        $repository = (new \ReflectionClass($class))->newInstanceWithoutConstructor();

        $contextProperty = new \ReflectionProperty(AbstractRepository::class, 'context');
        $contextProperty->setAccessible(true);
        $contextProperty->setValue($repository, $context);

        $dbProperty = new \ReflectionProperty(AbstractRepository::class, 'db');
        $dbProperty->setAccessible(true);
        $dbProperty->setValue($repository, $db);

        return $repository;
    }

    /**
     * @param string $sql
     *
     * @return string
     */
    private function normalize($sql)
    {
        return trim((string) preg_replace('/\s+/', ' ', $sql));
    }
}
