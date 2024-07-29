<?php

namespace PrestaShop\Module\PsEventbus\Repositories;

use Context;
use Db;
use DbQuery;

abstract class AbstractRepository
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var Db
     */
    private $db;

    /**
     * @var DbQuery
     */
    private $query;

    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->db = Db::getInstance();
    }

    public function getShopId()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        return (int) $this->context->shop->id;
    }

    protected function debugQuery()
    {
        $queryStringified = preg_replace('/\s+/', ' ', $this->query->build());

        return array_merge(
            (array) $this->query,
            ['queryStringified' => $queryStringified]
        );
    }

    protected function executeQuery()
    {
        return $this->db->executeS($this->query);
    }
}
