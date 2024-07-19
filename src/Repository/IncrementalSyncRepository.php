<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandlerInterface;

class IncrementalSyncRepository
{
    const INCREMENTAL_SYNC_TABLE = 'eventbus_incremental_sync';

    /**
     * @var \Db
     */
    private $db;
    /**
     * @var \Context
     */
    private $context;
    /**
     * @var ErrorHandlerInterface
     */
    private $errorHandler;

    /**
     * @var int
     */
    private $shopId;

    public function __construct(\Context $context, ErrorHandlerInterface $errorHandler)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;
        $this->errorHandler = $errorHandler;

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    /**
     * @param array<mixed> $data
     *
     * @return bool
     */
    public function insertIncrementalObject($data)
    {
        try {
            $arrayOfData = $data;

            if (!is_array($data[0])) {
                $arrayOfData = [$data];
            }

            $elementsCount = count($arrayOfData);
            $index = 0;

            $query = 'INSERT INTO `' . _DB_PREFIX_ . $this::INCREMENTAL_SYNC_TABLE . '` (type, id_object, id_shop, lang_iso, created_at) VALUES ';

            foreach ($arrayOfData as $currenData) {
                $dateTime = new \DateTime($currenData['created_at']);
                $date = $dateTime->format('Y-m-d H:i:s');

                $query .= "(
                    '{$this->db->escape($currenData['type'])}',
                    {$this->db->escape($currenData['id_object'])},
                    {$this->db->escape($currenData['id_shop'])},
                    '{$this->db->escape($currenData['lang_iso'])}',
                    '{$this->db->escape($date)}'
                )";

                if (++$index < $elementsCount) {
                    $query .= ',';
                }
            }

            $query .= ' 
                ON DUPLICATE KEY UPDATE 
                type = VALUES(type),
                id_object = VALUES(id_object),
                id_shop = VALUES(id_shop),
                lang_iso = VALUES(lang_iso),
                created_at = VALUES(created_at)
            ';

            return (bool) $this->db->query($query);
        } catch (\PrestaShopDatabaseException $e) {
            $this->errorHandler->handle(
                new \PrestaShopDatabaseException('Failed to insert incremental object', $e->getCode(), $e)
            );

            return false;
        }
    }

    /**
     * @param string $type
     * @param array<mixed> $objectIds
     * @param string $langIso
     *
     * @return bool
     */
    public function removeIncrementalSyncObjects($type, $objectIds, $langIso)
    {
        return $this->db->delete(
            self::INCREMENTAL_SYNC_TABLE,
            'type = "' . pSQL($type) . '"
            AND id_shop = ' . $this->shopId . '
            AND id_object IN(' . implode(',', array_map('intval', $objectIds)) . ')
            AND lang_iso = "' . pSQL($langIso) . '"'
        );
    }

    /**
     * @param string $type
     * @param string $langIso
     * @param int $limit
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getIncrementalSyncObjectIds($type, $langIso, $limit)
    {
        $query = new \DbQuery();

        $query->select('id_object')
            ->from(self::INCREMENTAL_SYNC_TABLE)
            ->where('lang_iso = "' . pSQL($langIso) . '"')
            ->where('id_shop = "' . $this->shopId . '"')
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
        $query = new \DbQuery();

        $query->select('COUNT(id_object) as count')
            ->from(self::INCREMENTAL_SYNC_TABLE)
            ->where('lang_iso = "' . pSQL($langIso) . '"')
            ->where('id_shop = "' . $this->shopId . '"')
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
            AND id_shop = ' . $this->shopId . '
            AND id_object = ' . (int) $objectId
        );
    }

    /**
     * @param string $type
     *
     * @return int
     */
    public function getIncrementalSyncObjectCountByType($type)
    {
        $query = new \DbQuery();

        $query->select('COUNT(type) as count')
            ->from(self::INCREMENTAL_SYNC_TABLE)
            ->where('type = "' . psql($type) . '"');

        return (int) $this->db->getValue($query);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function removeIncrementaSyncObjectByType($type)
    {
        return $this->db->delete(
            self::INCREMENTAL_SYNC_TABLE,
            'type = "' . pSQL($type) . '"'
        );
    }
}
