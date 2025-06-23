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
     * @param string|null $alias
     *
     * @return void
     */
    protected function generateMinimalQuery($tableName, $alias = null)
    {
        $this->query = new \DbQuery();

        $this->query->from($tableName, $alias);
    }

    /**
     * @return \Context
     */
    protected function getContext()
    {
        return $this->context;
    }

    /**
     * @return \Shop
     *
     * @throws \PrestaShopException
     */
    protected function getShopContext()
    {
        if ($this->context->shop === null) {
            throw new \PrestaShopException('No shop context');
        }

        return $this->context->shop;
    }

    /**
     * @param bool $disableCurrentExplain
     *
     * @return array<mixed>
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    protected function runQuery($disableCurrentExplain = null)
    {
        $explainSql = false;

        if (defined('PS_EVENTBUS_EXPLAIN_SQL_ENABLED')) {
            $explainSql = PS_EVENTBUS_EXPLAIN_SQL_ENABLED;
        }

        if ($explainSql && !$disableCurrentExplain) {
            $this->debugQuery();
        }

        /*
         * This is a workaround to avoid case where the table does not exist
         * Exemple with Taxonomies. 'fb_category_match' table does not exist in some cases
         * and the query will throw an exception.
         *
         * Previously, we have used the 'checkIfTableExist' method in parent class to check if the table exists
         * but it is not enough because explain_sql is not reachable in this case.
         *
         * The solution is to catch the exception and return an empty array when error code is '42S02' (Table does not exist error code)
         */
        try {
            $result = $this->db->executeS($this->query);

            // for 1.6 compatibility. executeS returns false if no result
            if ($result == false) {
                return [];
            }

            return (array) $result;
        } catch (\Exception $e) {
            if (!is_null($e->getPrevious()) && $e->getPrevious()->getCode() === '42S02') {
                return [];
            }

            throw $e;
        }
    }

    /**
     * @return void
     *
     * @throws \PrestaShopException
     */
    private function debugQuery()
    {
        $queryStringified = preg_replace('/\s+/', ' ', $this->query->build());
        $queryStringified = str_replace(['"'], ["'"], (string) $queryStringified);

        $response = array_merge(
            (array) $this->query,
            ['queryStringified' => $queryStringified]
        );

        CommonService::exitWithResponse($response);
    }
}
