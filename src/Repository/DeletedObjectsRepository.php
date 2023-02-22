<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandlerInterface;

class DeletedObjectsRepository
{
    public const DELETED_OBJECTS_TABLE = 'eventbus_deleted_objects';

    /**
     * @var \Db
     */
    private $db;

    /**
     * @var ErrorHandlerInterface
     */
    private $errorHandler;

    public function __construct(\Db $db, ErrorHandlerInterface $errorHandler)
    {
        $this->db = $db;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @param int $shopId
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getDeletedObjectsGrouped($shopId)
    {
        $query = new \DbQuery();

        $query->select('type, GROUP_CONCAT(id_object SEPARATOR ";") as ids')
            ->from(self::DELETED_OBJECTS_TABLE)
            ->where('id_shop = ' . (int) $shopId)
            ->groupBy('type');

        $result = $this->db->executeS($query);

        return is_array($result) ? $result : [];
    }

    /**
     * @param int $objectId
     * @param string $objectType
     * @param string $date
     * @param int $shopId
     *
     * @return bool
     */
    public function insertDeletedObject($objectId, $objectType, $date, $shopId)
    {
        try {
            return $this->db->insert(
                self::DELETED_OBJECTS_TABLE,
                [
                    'id_shop' => $shopId,
                    'id_object' => $objectId,
                    'type' => $objectType,
                    'created_at' => $date,
                ],
                false,
                true,
                \Db::ON_DUPLICATE_KEY
            );
        } catch (\PrestaShopDatabaseException $e) {
            $this->errorHandler->handle($e);

            return false;
        }
    }

    /**
     * @param string $type
     * @param array $objectIds
     * @param int $shopId
     *
     * @return bool
     */
    public function removeDeletedObjects($type, $objectIds, $shopId)
    {
        return $this->db->delete(
            self::DELETED_OBJECTS_TABLE,
            'type = "' . pSQL($type) . '"
            AND id_shop = ' . (int) $shopId . '
            AND id_object IN(' . implode(',', array_map('intval', $objectIds)) . ')'
        );
    }
}
