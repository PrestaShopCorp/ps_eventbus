<?php

/*
 * Minimal doubles of the PrestaShop core used by the repositories, for unit tests that check the SQL they send.
 * They are only declared when the real core is not loaded.
 */

if (!defined('_DB_PREFIX_')) {
    define('_DB_PREFIX_', 'ps_');
}

if (!function_exists('pSQL')) {
    function pSQL($string, $htmlOK = false)
    {
        return addslashes((string) $string);
    }
}

if (!class_exists('Db')) {
    class Db
    {
        /** @var string[] */
        public $executed = [];

        /** @var array<int, array{0: string, 1: string}> */
        public $deleted = [];

        /** @var array<int, array<string, mixed>> rows returned by executeS() */
        public $rows = [];

        /** @var array<string, mixed>|false row returned by getRow() */
        public $row = false;

        public function execute($sql, $use_cache = true)
        {
            $this->executed[] = $sql;

            return true;
        }

        public function executeS($sql, $array = true, $use_cache = true)
        {
            $this->executed[] = $sql;

            return $this->rows;
        }

        public function getRow($sql, $use_cache = true)
        {
            $this->executed[] = $sql;

            return $this->row;
        }

        public function delete($table, $where = '', $limit = 0, $use_cache = true, $add_prefix = true)
        {
            $this->deleted[] = [$table, $where];

            return true;
        }
    }
}

if (!class_exists('Configuration')) {
    class Configuration
    {
        public static function get($key)
        {
            return null;
        }
    }
}

if (!class_exists('Shop')) {
    class Shop
    {
        /** @var int */
        public $id;
    }
}

if (!class_exists('Context')) {
    class Context
    {
        /** @var Shop */
        public $shop;
    }
}
