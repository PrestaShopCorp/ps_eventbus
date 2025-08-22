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

namespace PrestaShop\Module\PsEventbus\Handler\ErrorHandler;

use PrestaShop\Module\PsEventbus\Api\HttpClient;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Exception\FirebaseException;
use PrestaShop\Module\PsEventbus\Service\CommonService;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ErrorHandler
{
    /** @var string|null */
    private $sentryUrl;

    /** @var string */
    private $sentryKey;

    /** @var string */
    private $sentryEnv;

    /** @var array<mixed> */
    private $tags = [];

    // Disable cloning
    private function __clone()
    {
    }

    /**
     * @param string $sentryDsn
     * @param string $sentryEnv
     */
    public function __construct($sentryDsn, $sentryEnv)
    {
        try {
            $parts = parse_url($sentryDsn);

            if ($parts === false) {
                throw new \InvalidArgumentException('Invalid Sentry DSN');
            }

            if (!isset($parts['host'], $parts['path'], $parts['user'])) {
                throw new \PrestaShopException('Invalid Sentry DSN');
            }

            $projectId = ltrim($parts['path'], '/');
            $this->sentryKey = $parts['user'];
            $this->sentryUrl = sprintf('https://%s/api/%s/store/', $parts['host'], $projectId);
            $this->sentryEnv = $sentryEnv;

            $accountsModule = \Module::getInstanceByName('ps_accounts');
            $eventbusModule = \Module::getInstanceByName('ps_eventbus');

            $shopUuid = $psAccountVersion = null;

            if ($accountsModule) {
                $accountService = $accountsModule->getService(
                    'PrestaShop\Module\PsAccounts\Service\PsAccountsService'
                );
                $shopUuid = $accountService->getShopUuid();
                $psAccountVersion = $accountsModule->version;
            }

            $this->tags = [
                'shop_id' => $shopUuid,
                'ps_eventbus_version' => $eventbusModule ? $eventbusModule->version : null,
                'ps_accounts_version' => $psAccountVersion,
                'php_version' => phpversion(),
                'prestashop_version' => _PS_VERSION_,
                'ps_eventbus_is_enabled' => \Module::isEnabled('ps_eventbus'),
                'ps_eventbus_is_installed' => \Module::isInstalled('ps_eventbus'),
            ];
        } catch (\Exception $e) {
            $this->sentryUrl = null;
        }
    }

    /**
     * @param \Exception $exception
     * @param bool|null $silent
     *
     * @return void
     */
    public function handle($exception, $silent = null)
    {
        $logsEnabled = defined('PS_EVENTBUS_LOGS_ENABLED') ? PS_EVENTBUS_LOGS_ENABLED : false;
        $verboseEnabled = defined('PS_EVENTBUS_VERBOSE_ENABLED') ? PS_EVENTBUS_VERBOSE_ENABLED : false;

        if ($logsEnabled) {
            \PrestaShopLogger::addLog(
                $exception->getMessage() . ' : ' . $exception->getFile() . ':' . $exception->getLine() . ' | ' . $exception->getTraceAsString(),
                3,
                $exception->getCode() > 0 ? $exception->getCode() : 500,
                'Module',
                \Module::getModuleIdByName('ps_eventbus'),
                true
            );
        }

        if (_PS_MODE_DEV_ && $verboseEnabled) {
            throw $exception;
        }

        if ($this->sentryUrl) {
            $this->sendToSentry($exception);
        }

        if (!$silent) {
            CommonService::exitWithExceptionMessage($exception);
        }
    }

    /**
     * @param \Throwable $exception
     *
     * @return void
     */
    private function sendToSentry(\Throwable $exception)
    {
        $level = $this->mapExceptionToCategory($exception);
        $configurationPsShopEmail = \Configuration::get('PS_SHOP_EMAIL');

        $exceptionTags = [
            'exception_class' => get_class($exception),
            'code' => (string) $exception->getCode(),
        ];

        $event = [
            'message' => $exception->getMessage(),
            'level' => $level,
            'logger' => 'ps_eventbus',
            'platform' => 'php',
            'environment' => $this->sentryEnv,
            'tags' => array_merge($this->tags, $exceptionTags),
            'user' => [
                'id' => $this->tags['shop_id'] ? $this->tags['shop_id'] : null,
                'email' => $configurationPsShopEmail,
            ],
            'exception' => [
                'values' => [[
                    'type' => get_class($exception),
                    'value' => $exception->getMessage(),
                    'stacktrace' => [
                        'frames' => $this->buildFrames($exception->getTrace()),
                    ],
                ]],
            ],
            'extra' => [
                'code' => $exception->getCode(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ],
            'timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
        ];

        HttpClient::getInstance()->post(
            (string) $this->sentryUrl,
            [
                'Authorization' => 'Sentry sentry_version=7, sentry_client=ps_eventbus/1.0, sentry_key=' . $this->sentryKey,
                'Content-Type' => 'application/json',
            ],
            $event
        );
    }

    /**
     * Determines a Sentry level from PrestaShop/Symfony exception types
     *
     * @param \Throwable $e
     *
     * @return string
     */
    private function mapExceptionToCategory(\Throwable $e)
    {
        switch ($e) {
            case $e instanceof \PrestaShopDatabaseException:
                return 'fatal';
            case $e instanceof EnvVarException:
                return 'error';
            case $e instanceof FirebaseException:
                return 'warning';
        }

        if ($e instanceof \ErrorException) {
            switch ($e->getSeverity()) {
                case E_NOTICE:
                case E_USER_NOTICE:
                case E_DEPRECATED:
                case E_USER_DEPRECATED:
                    return 'info';

                case E_WARNING:
                case E_USER_WARNING:
                    return 'warning';

                case E_RECOVERABLE_ERROR:
                    return 'error';

                case E_ERROR:
                case E_USER_ERROR:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_PARSE:
                    return 'fatal';

                default:
                    return 'error';
            }
        }

        return 'error';
    }

    /**
     * Build Sentry stack frames from a PHP error stack trace.
     *
     * @param array<mixed> $trace
     *
     * @return array<mixed>
     */
    private function buildFrames(array $trace)
    {
        $frames = [];
        foreach (array_reverse($trace) as $t) {
            $file = $t['file'] ? $t['file'] : null;
            $line = (int) ($t['line'] ? $t['line'] : 0);

            // 1) Variables/args (scrub + truncate)
            $vars = [];
            if (!empty($t['args'])) {
                foreach ($t['args'] as $i => $arg) {
                    $vars['arg' . $i] = $this->scrubAndNormalize($arg, 0);
                }
            }

            // 2) Code Context
            $codeContext = $this->getCodeContext($file, $line, 3);

            $frames[] = [
                'filename' => $file ?: '<internal>',
                'lineno' => $line,
                'function' => $t['function'] ? $t['function'] : '',
                'in_app' => $this->isInApp($file),
                'vars' => $vars ?: null,
                'context_line' => $codeContext[0],
                'pre_context' => $codeContext[1] ?: null,
                'post_context' => $codeContext[2] ?: null,
            ];
        }

        return $frames;
    }

    /**
     * Check if the file is part of the application code.
     *
     * @param string $file
     *
     * @return bool
     */
    private function isInApp(string $file)
    {
        if (!$file) {
            return false;
        }

        // Mark module files as "in_app" for better readability
        return (bool) preg_match('#/modules/ps_eventbus/#', $file);
    }

    /**
     * Get the code context around a specific line in a file.
     *
     * @param string $file
     * @param int $line
     * @param int $radius
     *
     * @return array<mixed>
     */
    private function getCodeContext(string $file, int $line, int $radius)
    {
        if (!$radius) {
            $radius = 3; // Default radius if not specified
        }

        if (!$file || $line <= 0 || !is_readable($file)) {
            return [null, [], []];
        }

        $lines = @file($file, FILE_IGNORE_NEW_LINES);

        if (!$lines) {
            return [null, [], []];
        }

        $idx = $line - 1;
        $start = max(0, $idx - $radius);
        $end = min(count($lines) - 1, $idx + $radius);

        $pre = array_slice($lines, $start, max(0, $idx - $start));
        $curr = $lines[$idx] ? $lines[$idx] : null;
        $post = array_slice($lines, $idx + 1, max(0, $end - $idx));

        // Hard size limit to avoid exceeding event size
        $truncate = function ($s) {
            return mb_strimwidth((string) $s, 0, 500, '…');
        };

        $pre = array_map($truncate, $pre);
        $curr = $curr ? $truncate($curr) : null;
        $post = array_map($truncate, $post);

        return [$curr, $pre, $post];
    }

    /**
     * Scrub and normalize a value for safe logging.
     *
     * @param mixed $value
     * @param int $depth
     *
     * @return mixed
     */
    private function scrubAndNormalize($value, int $depth)
    {
        if ($depth > 3) { // avoid giant structures
            return '/* depth limit */';
        }

        // Scalar types
        if (is_null($value) || is_bool($value) || is_int($value) || is_float($value)) {
            return $value;
        }
        if (is_string($value)) {
            // Truncate very long strings
            if (strlen($value) > 2000) {
                return mb_substr($value, 0, 2000) . '…';
            }

            return $value;
        }

        // Objets
        if (is_object($value)) {
            // Do not serialize PDO, cURL, etc. resources
            if ($value instanceof \Throwable) {
                return sprintf('Throwable(%s): %s', get_class($value), $value->getMessage());
            }
            // Simple representation of objects
            $out = ['__class' => get_class($value)];
            // Attempt to extract public properties
            foreach (get_object_vars($value) as $k => $v) {
                $out[$k] = $this->scrubAndNormalize($v, $depth + 1);
            }

            return $out;
        }

        if (is_array($value)) {
            // Scrub sensitive keys
            $scrubKeys = ['password', 'passwd', 'pwd', 'secret', 'token', 'api_key', 'apikey', 'authorization', 'cookie', 'set-cookie', 'bearer'];
            $out = [];
            foreach ($value as $k => $v) {
                $lk = is_string($k) ? strtolower($k) : $k;
                if (is_string($lk) && in_array($lk, $scrubKeys, true)) {
                    $out[$k] = '***';
                } else {
                    $out[$k] = $this->scrubAndNormalize($v, $depth + 1);
                }
            }

            // Hard size limit for array
            if (count($out) > 50) {
                $out = array_slice($out, 0, 50, true) + ['__truncated' => '…'];
            }

            return $out;
        }

        if (is_resource($value)) {
            return sprintf('resource(%s)', get_resource_type($value));
        }

        return '(unserializable)';
    }
}
