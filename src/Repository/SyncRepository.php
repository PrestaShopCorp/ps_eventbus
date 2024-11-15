<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\PsEventbus\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SyncRepository extends AbstractRepository
{
    const TYPE_SYNC_TABLE_NAME = 'eventbus_type_sync';
    const JOB_TABLE_NAME = 'eventbus_job';

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
                'id_shop' => parent::getShopContext()->id,
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
        $this->generateMinimalQuery(self::JOB_TABLE_NAME, 'ej');

        $this->query->where('ej.job_id = "' . pSQL($jobId) . '"');
        $this->query->select('ej.*');

        return $this->db->getRow($this->query);
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return array<mixed>|bool|object|null
     */
    public function findTypeSync($type, $langIso = null)
    {
        $this->generateMinimalQuery(self::TYPE_SYNC_TABLE_NAME, 'ets');

        $this->query
            ->where('ets.type = "' . pSQL($type) . '"')
            ->where('ets.lang_iso = "' . pSQL((string) $langIso) . '"')
            ->where('ets.id_shop = ' . parent::getShopContext()->id)
        ;

        $this->query->select('ets.*');

        return $this->db->getRow($this->query);
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return bool
     */
    public function isFullSyncDoneForThisTypeSync($type, $langIso = null)
    {
        $this->generateMinimalQuery(self::TYPE_SYNC_TABLE_NAME, 'ets');

        $this->query
            ->where('ets.type = "' . pSQL($type) . '"')
            ->where('ets.lang_iso = "' . pSQL((string) $langIso) . '"')
            ->where('ets.id_shop = ' . parent::getShopContext()->id)
        ;

        $this->query->select('ets.full_sync_finished');

        return (bool) $this->db->getValue($this->query);
    }
}
