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

namespace PrestaShop\Module\PsEventbus\Helper;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Class CustomDbQuery
 *
 * This class is a custom implementation of DbQuery to build SQL queries in a more flexible way.
 * It allows to create complex queries with CTEs.
 */
class CustomDbQuery extends \DbQuery
{
    /**
     * List of data to build the query.
     *
     * @var array
     */
    protected $query = [
        'type' => 'SELECT',
        'cte' => null, // Common Table Expression
        'select' => [],
        'from' => [],
        'join' => [],
        'where' => [],
        'group' => [],
        'having' => [],
        'order' => [],
        'limit' => ['offset' => 0, 'limit' => 0],
    ];

    /**
     * Sets Common Table Expression (CTE) for the query.
     *
     * @param string $query CTE query
     *
     * @return $this
     */
    public function addCte($query)
    {
        $this->query['cte'][] = $query;

        return $this;
    }

    /**
     * Generates query and return SQL string.
     *
     * @return string
     *
     * @throws PrestaShopException
     */
    public function build()
    {
        if ($this->query['cte']) {
            $sql = implode(",\n", $this->query['cte']) . "\n";
        } else {
            $sql = '';
        }

        if ($this->query['type'] == 'SELECT') {
            $sql .= 'SELECT ' . (($this->query['select']) ? implode(",\n", $this->query['select']) : '*') . "\n";
        } else {
            $sql .= $this->query['type'] . ' ';
        }

        if (!$this->query['from']) {
            throw new \PrestaShopException('Table name not set in DbQuery object. Cannot build a valid SQL query.');
        }

        $sql .= 'FROM ' . implode(', ', $this->query['from']) . "\n";

        if ($this->query['join']) {
            $sql .= implode("\n", $this->query['join']) . "\n";
        }

        if ($this->query['where']) {
            $sql .= 'WHERE (' . implode(') AND (', $this->query['where']) . ")\n";
        }

        if ($this->query['group']) {
            $sql .= 'GROUP BY ' . implode(', ', $this->query['group']) . "\n";
        }

        if ($this->query['having']) {
            $sql .= 'HAVING (' . implode(') AND (', $this->query['having']) . ")\n";
        }

        if ($this->query['order']) {
            $sql .= 'ORDER BY ' . implode(', ', $this->query['order']) . "\n";
        }

        if ($this->query['limit']['limit']) {
            $limit = $this->query['limit'];
            $sql .= 'LIMIT ' . ($limit['offset'] ? $limit['offset'] . ', ' : '') . $limit['limit'];
        }

        return $sql;
    }
}
