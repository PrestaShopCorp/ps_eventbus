<?php

namespace PrestaShop\Module\PsEventbus\Repository\NewRepository;

use Context;
use PrestaShop\Module\PsEventbus\Service\CommonService;
use Shop;

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
        $context = \Context::getContext();

        if ($context == null) {
            throw new \PrestaShopException('Context not found');
        }

        $this->context = $context;
        $this->db = \Db::getInstance();
    }

    /**
     * @return \Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return \Shop
     *
     * @throws \PrestaShopException
     */
    public function getShopContext()
    {   
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        return $this->context->shop;
    }

    /**
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    protected function runQuery($debug)
    {
        if ($debug != null && $debug === true) {
            $this->debugQuery();
        }

        $result = $this->db->executeS($this->query);

        return is_array($result) ? $result : [];
    }

    /**
     * @return void
     *
     * @throws \PrestaShopException
     */
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
