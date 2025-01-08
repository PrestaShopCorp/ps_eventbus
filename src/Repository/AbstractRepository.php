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
     * @param string $tableName
     *
     * @return array<mixed>|bool|\mysqli_result|\PDOStatement|resource|null
     *
     * @throws \PrestaShopException
     * @throws \PrestaShopDatabaseException
     */
    protected function checkIfTableExist($tableName)
    {
        $request = 'SELECT * FROM information_schema.tables WHERE table_name LIKE \'' . $tableName . '\' LIMIT 1;';

        return $this->db->executeS($request);
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

        return (array) $this->db->executeS($this->query);
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
