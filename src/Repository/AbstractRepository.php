<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use PrestaShop\Module\PsEventbus\Service\CommonService;

abstract class AbstractRepository
{
    /**
     * @var \Context
     */
    private $context;

    /**
     * @var \Db
     */
    private $db;

    /**
     * @var \DbQuery
     */
    protected $query;

    public function __construct()
    {
        $this->context = \Context::getContext();
        $this->db = \Db::getInstance();
    }

    public function getShopId()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        return (int) $this->context->shop->id;
    }

    protected function runQuery($debug)
    {
        if ($debug) {
            $this->debugQuery();
        }

        return $this->db->executeS($this->query);
    }

    private function debugQuery()
    {
        $queryStringified = preg_replace('/\s+/', ' ', $this->query->build());

        $response = array_merge(
            (array) $this->query,
            ['queryStringified' => $queryStringified]
        );

        CommonService::exitWithResponse($response);
    }
}
