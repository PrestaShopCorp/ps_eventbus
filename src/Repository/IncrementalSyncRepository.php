<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Context;
use Db;
use DbQuery;

class IncrementalSyncRepository
{
    const INCREMENTAL_SYNC_TABLE = 'eventbus_incremental_sync';

    /**
     * @var Db
     */
    private $db;
    /**
     * @var Context
     */
    private $context;

    public function __construct(Db $db, Context $context)
    {
        $this->db = $db;
        $this->context = $context;
    }

    /**
     * @param int $objectId
     * @param string $objectType
     * @param string $date
     * @param int $shopId
     * @param string $langIso
     *
     * @return bool
     */
    public function insertIncrementalObject($objectId, $objectType, $date, $shopId, $langIso)
    {
        try {
            return $this->db->insert(
                self::INCREMENTAL_SYNC_TABLE,
                [
                    'id_shop' => $shopId,
                    'id_object' => $objectId,
                    'type' => $objectType,
                    'created_at' => $date,
                    'lang_iso' => $langIso,
                ],
                false,
                true,
                Db::ON_DUPLICATE_KEY
            );
        } catch (\PrestaShopDatabaseException $e) {
            return false;
        }
    }

    /**
     * @param string $type
     * @param array $objectIds
     * @param string $langIso
     *
     * @return bool
     */
    public function removeIncrementalSyncObjects($type, $objectIds, $langIso)
    {
        return $this->db->delete(
            self::INCREMENTAL_SYNC_TABLE,
            'type = "' . pSQL($type) . '"
            AND id_shop = ' . $this->context->shop->id . '
            AND id_object IN(' . implode(',', array_map('intval', $objectIds)) . ')
            AND lang_iso = "' . pSQL($langIso) . '"'
        );
    }

    /**
     * @param string $type
     * @param string $langIso
     * @param int $limit
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getIncrementalSyncObjectIds($type, $langIso, $limit)
    {
        $query = new DbQuery();

        $query->select('id_object')
            ->from(self::INCREMENTAL_SYNC_TABLE)
            ->where('lang_iso = "' . pSQL($langIso) . '"')
            ->where('id_shop = "' . $this->context->shop->id . '"')
            ->where('type = "' . pSQL($type) . '"')
            ->limit($limit);

        $result = $this->db->executeS($query);

        if (is_array($result) && !empty($result)) {
            return array_map(function ($object) {
                return $object['id_object'];
            }, $result);
        }

        return [];
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingIncrementalObjects($type, $langIso)
    {
        $query = new DbQuery();

        $query->select('COUNT(id_object) as count')
            ->from(self::INCREMENTAL_SYNC_TABLE)
            ->where('lang_iso = "' . pSQL($langIso) . '"')
            ->where('id_shop = "' . $this->context->shop->id . '"')
            ->where('type = "' . pSQL($type) . '"');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param string $type
     * @param int $objectId
     *
     * @return bool
     */
    public function removeIncrementalSyncObject($type, $objectId)
    {
        return $this->db->delete(
            self::INCREMENTAL_SYNC_TABLE,
            'type = "' . pSQL($type) . '"
            AND id_shop = ' . $this->context->shop->id . '
            AND id_object = ' . (int) $objectId
        );
    }
}
