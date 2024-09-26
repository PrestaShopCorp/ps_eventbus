<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

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
     * @param string $date
     * @param bool $fullSyncFinished
     * @param string $langIso
     *
     * @return bool
     */
    public function upsertTypeSync($type, $offset, $date, $fullSyncFinished, $langIso = null)
    {
        return $this->db->insert(
            self::TYPE_SYNC_TABLE_NAME,
            [
                'type' => pSQL((string) $type),
                'offset' => (int) $offset,
                'id_shop' => $this->shopId,
                'lang_iso' => pSQL((string) $langIso),
                'full_sync_finished' => (int) $fullSyncFinished,
                'last_sync_date' => pSQL($date),
            ],
            false,
            true,
            \Db::ON_DUPLICATE_KEY
        );
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
