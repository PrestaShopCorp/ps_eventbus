<?php

/*
 * Minimal doubles of the core Module and Configuration classes, only declared when the core is not loaded: they let
 * unit tests load the module class and the services that call them. Module records its static calls, and throws
 * Module::$failWith when it is set.
 */

if (!defined('_PS_MODE_DEV_')) {
    define('_PS_MODE_DEV_', false);
}

if (!class_exists('Module', false)) {
    class Module
    {
        /** @var string[] */
        public static $calls = [];

        /** @var Exception|Throwable|null */
        public static $failWith;

        /** @var string */
        public $version = '0.0.0';

        public static function getInstanceByName($name)
        {
            self::record('getInstanceByName ' . $name);

            return false;
        }

        public static function isEnabled($name)
        {
            self::record('isEnabled ' . $name);

            return false;
        }

        public static function isInstalled($name)
        {
            self::record('isInstalled ' . $name);

            return false;
        }

        private static function record($call)
        {
            self::$calls[] = $call;

            if (self::$failWith !== null) {
                throw self::$failWith;
            }
        }
    }
}

if (!class_exists('Configuration', false)) {
    class Configuration
    {
        public static function get($key)
        {
            return null;
        }
    }
}
