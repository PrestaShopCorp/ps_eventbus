<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

use Context;
use DbQuery;
use Language;
use PrestaShopException;

class CarrierRepository extends AbstractRepository implements RepositoryInterface
{
    const TABLE_NAME = 'carrier';

    /**
     * @param string $langIso
     *
     * @return mixed
     *
     * @throws PrestaShopException
     */
    public function generateBaseQuery($langIso)
    { 
        $langId = (int) Language::getIdByIso($langIso);
        $context = Context::getContext();

        if ($context === null) {
            throw new PrestaShopException('Context is null');
        }

        if ($context->shop === null) {
            throw new PrestaShopException('No shop context');
        }

        $this->query = new DbQuery();

        $this->query->from('carrier', 'c')    
            ->leftJoin('carrier_lang', 'cl', 'cl.id_carrier = c.id_carrier AND cl.id_lang = ' . $langId)
            ->leftJoin('carrier_shop', 'cs', 'cs.id_carrier = c.id_carrier')
            ->where('cs.id_shop = ' . $context->shop->id)
            ->where('deleted=0')
        ;

        $this->query->select('c.*');
    }
    
    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws PrestaShopException
     * @throws PrestaShopDatabaseException
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $this->generateBaseQuery($langIso);

        $this->query->limit((int) $limit, (int) $offset);

        return $this->runQuery($debug);
    }

    /**
     * @param int $limit
     * @param array<mixed> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws PrestaShopException
     * @throws PrestaShopDatabaseException
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $this->generateBaseQuery($langIso);

        $this->query
            ->where('c.id_carrier IN(' . implode(',', array_map('intval', $contentIds)) . ')')
            ->limit($limit);

        return $this->runQuery($debug);
    }

    /**
     * @param int $offset
     * @param string $langIso
     * @param bool $debug
     *
     * @return int
     *
     * @throws PrestaShopException
     * @throws PrestaShopDatabaseException
     */
    public function countFullSyncContentLeft($offset, $langIso, $debug)
    {
        $result = $this->getContentsForFull($offset, 1, $langIso, $debug);

        if (!is_array($result) || empty($result)) {
            return 0;
        }

        return count($result);
    }
}
