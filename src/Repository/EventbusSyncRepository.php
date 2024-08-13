<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Config\Config;

class EventbusSyncRepository
{
    const TYPE_SYNC_TABLE_NAME = 'eventbus_type_sync';
    const JOB_TABLE_NAME = 'eventbus_job';

    /**
     * @var \Db
     */
    private $db;
    /**
     * @var \Context
     */
    private $context;

    /**
     * @var int
     */
    private $shopId;

    public function __construct(\Context $context)
    {
        $this->db = \Db::getInstance();
        $this->context = $context;

        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        $this->shopId = (int) $this->context->shop->id;
    }

    /**
     * @param string $type
     * @param int $offset
     * @param string $lastSyncDate
     * @param string $langIso
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException
     */
    public function insertTypeSync($type, $offset, $lastSyncDate, $langIso = null)
    {
        $result = $this->db->insert(
            self::TYPE_SYNC_TABLE_NAME,
            [
                'id_shop' => $this->shopId,
                'type' => pSQL((string) $type),
                'offset' => (int) $offset,
                'last_sync_date' => pSQL((string) $lastSyncDate),
                'lang_iso' => pSQL((string) $langIso),
            ]
        );

        if (!$result) {
            throw new \PrestaShopDatabaseException('Failed to insert type sync', Config::DATABASE_INSERT_ERROR_CODE);
        }

        return $result;
    }

    /**
     * @param string $jobId
     * @param string $date
     *
     * @return bool
     *
     * @throws \PrestaShopDatabaseException
     */
    public function insertJob($jobId, $date)
    {
        return $this->db->insert(
            self::JOB_TABLE_NAME,
            [
                'job_id' => pSQL($jobId),
                'created_at' => pSQL($date),
            ]
        );
    }

    /**
     * @param string $jobId
     *
     * @return array<mixed>|bool|false|object|null
     */
    public function findJobById($jobId)
    {
        $query = new \DbQuery();
        $query->select('*')
            ->from(self::JOB_TABLE_NAME)
            ->where('job_id = "' . pSQL($jobId) . '"');

        return $this->db->getRow($query);
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return array<mixed>|bool|object|null
     */
    public function findTypeSync($type, $langIso = null)
    {
        $query = new \DbQuery();
        $query->select('*')
            ->from(self::TYPE_SYNC_TABLE_NAME)
            ->where('type = "' . pSQL($type) . '"')
            ->where('lang_iso = "' . pSQL((string) $langIso) . '"')
            ->where('id_shop = ' . $this->shopId);

        return $this->db->getRow($query);
    }

    /**
     * @param string $type
     * @param int $offset
     * @param string $date
     * @param bool $fullSyncFinished
     * @param string $langIso
     *
     * @return bool
     */
    public function updateTypeSync($type, $offset, $date, $fullSyncFinished, $langIso = null)
    {
        return $this->db->update(
            self::TYPE_SYNC_TABLE_NAME,
            [
                'offset' => (int) $offset,
                'full_sync_finished' => (int) $fullSyncFinished,
                'last_sync_date' => pSQL($date),
            ],
            'type = "' . pSQL($type) . '"
            AND lang_iso = "' . pSQL((string) $langIso) . '"
            AND id_shop = ' . $this->shopId
        );
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return bool
     */
    public function isFullSyncDoneForThisTypeSync($type, $langIso = null)
    {
        $query = new \DbQuery();

        $query->select('full_sync_finished')
            ->from(self::TYPE_SYNC_TABLE_NAME)
            ->where('type = "' . pSQL($type) . '"')
            ->where('lang_iso = "' . pSQL((string) $langIso) . '"')
            ->where('id_shop = ' . $this->shopId);

        return (bool) $this->db->getValue($query);
    }
}
