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

use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;

if (!defined('_PS_VERSION_')) {
    exit;
}

class IncrementalSyncRepository extends AbstractRepository
{
    const TABLE_NAME = 'eventbus_incremental_sync';

    /**
     * @var ErrorHandler
     */
    private $errorHandler;

    public function __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;

        parent::__construct();
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

            $query = 'INSERT INTO `' . _DB_PREFIX_ . self::TABLE_NAME . '` (type, id_object, id_shop, lang_iso, action, created_at) VALUES ';

            foreach ($arrayOfData as $currenData) {
                $dateTime = new \DateTime($currenData['created_at']);
                $date = $dateTime->format('Y-m-d H:i:s');

                $query .= "(
                    '{$this->db->escape($currenData['type'])}',
                    '{$this->db->escape($currenData['id_object'])}',
                    {$this->db->escape($currenData['id_shop'])},
                    '{$this->db->escape($currenData['lang_iso'])}',
                    '{$this->db->escape($currenData['action'])}',
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
                action = VALUES(action),
                created_at = VALUES(created_at)
            ';

            return (bool) $this->db->query($query);
        } catch (\PrestaShopDatabaseException $exception) {
            $this->errorHandler->handle(
                new \PrestaShopDatabaseException('Failed to insert incremental object', $exception->getCode(), $exception)
            );

            return false;
        }
    }

    /**
     * @param string $type
     * @param array<mixed> $contentIds
     * @param string $langIso
     *
     * @return bool
     */
    public function removeIncrementalSyncObjects($type, $contentIds, $langIso)
    {
        return $this->db->delete(
            self::TABLE_NAME,
            "type = '" . pSQL($type) . "'
            AND id_shop = " . parent::getShopContext()->id . "
            AND id_object IN('" . implode("','", $contentIds) . "')
            AND lang_iso = '" . pSQL($langIso) . "'"
        );
    }

    /**
     * @param string $shopContent
     * @param string $langIso
     * @param int $limit
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getIncrementalSyncObjects($shopContent, $langIso, $limit)
    {
        $this->generateMinimalQuery(self::TABLE_NAME, 'eis');

        $this->query
            ->where('eis.lang_iso = "' . pSQL($langIso) . '"')
            ->where('eis.id_shop = "' . parent::getShopContext()->id . '"')
            ->where('eis.type = "' . pSQL($shopContent) . '"')
            ->limit($limit)
        ;

        $this->query
            ->select('eis.type')
            ->select('eis.id_object as id')
            ->select('eis.action')
        ;

        return $this->runQuery(true);
    }

    /**
     * @param string $type
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingIncrementalObjects($type, $langIso)
    {
        $this->generateMinimalQuery(self::TABLE_NAME, 'eis');

        $this->query
            ->where('eis.lang_iso = "' . pSQL($langIso) . '"')
            ->where('eis.id_shop = "' . parent::getShopContext()->id . '"')
            ->where('eis.type = "' . pSQL($type) . '"')
        ;

        $this->query->select('COUNT(eis.id_object) as count');

        return (int) $this->db->getValue($this->query);
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
            self::TABLE_NAME,
            'type = "' . pSQL($type) . '"
            AND id_shop = ' . parent::getShopContext()->id . '
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
        $this->generateMinimalQuery(self::TABLE_NAME, 'eis');

        $this->query->where('eis.type = "' . psql($type) . '"');
        $this->query->select('COUNT(eis.type) as count');

        return (int) $this->db->getValue($this->query);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function removeIncrementaSyncObjectByType($type)
    {
        return $this->db->delete(
            self::TABLE_NAME,
            'type = "' . pSQL($type) . '"'
        );
    }
}
