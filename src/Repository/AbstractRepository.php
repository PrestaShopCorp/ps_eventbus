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

use PrestaShop\Module\PsEventbus\Service\CommonService;

if (!defined('_PS_VERSION_')) {
    exit;
}

abstract class AbstractRepository
{
    /**
     * @var \Context
     */
    private $context;

    /**
     * @var \Db
     */
    protected $db;

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
     * @param string $tableName
     * @param string $alias
     *
     * @return void
     */
    public function generateMinimalQuery($tableName, $alias)
    {
        $this->query = new \DbQuery();

        $this->query->from($tableName, $alias);
    }

    /**
     * @return \Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return \Language|\PrestaShopBundle\Install\Language
     *
     * @throws \PrestaShopException
     */
    public function getLanguageContext()
    {
        if ($this->context->language === null) {
            throw new \PrestaShopException('No language context');
        }

        return $this->context->language;
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

     * 
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    protected function runQuery()
    {
        if (PS_EVENTBUS_EXPLAIN_SQL_ENABLED === true) {
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
