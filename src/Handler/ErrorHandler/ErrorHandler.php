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
use PrestaShop\Module\PsEventbus\Service\CommonService;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ErrorHandler
{
    private $sentryUrl;
    private $sentryKey;
    private $sentryEnv;
    private $tags = [];

    public function __construct($sentryDsn, $sentryEnv)
    {
        try {
            // Ex: https://<public_key>@sentry.io/<project_id>
            $parts = parse_url($sentryDsn);
            if (!isset($parts['host'], $parts['path'], $parts['user'])) {
                throw new \Exception('Invalid Sentry DSN');
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
                'shop_id'                  => $shopUuid,
                'ps_eventbus_version'      => $eventbusModule->version ?? null,
                'ps_accounts_version'      => $psAccountVersion,
                'php_version'              => phpversion(),
                'prestashop_version'       => _PS_VERSION_,
                'ps_eventbus_is_enabled'   => \Module::isEnabled((string) $eventbusModule->name),
                'ps_eventbus_is_installed' => \Module::isInstalled((string) $eventbusModule->name),
            ];
        } catch (\Exception $e) {
            $this->sentryUrl = null;
        }
    }

    public function handle($exception, $silent = null)
    {
        $logsEnabled    = defined('PS_EVENTBUS_LOGS_ENABLED') ? PS_EVENTBUS_LOGS_ENABLED : false;
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
            throw $exception; // en dev on veut voir l’erreur réelle
        }

        if ($this->sentryUrl) {
            $this->sendToSentry($exception, 'error');
        }

        // IMPORTANT : ne remonte jamais la réponse Sentry à l’utilisateur
        if (!$silent) {
            // Affiche seulement ton message générique côté FO/BO
            CommonService::exitWithExceptionMessage($exception);
        }
    }

    private function sendToSentry(\Throwable $exception, string $category = 'error'): void
    {
        $configurationPsShopEmail = \Configuration::get('PS_SHOP_EMAIL');

        $event = [
            'message'     => $exception->getMessage(),
            'level'       => 'error',
            'logger'      => 'ps_eventbus',
            'platform'    => 'php',
            'environment' => $this->sentryEnv,
            'tags'        => array_merge($this->tags, ['category' => $category]),
            'user'        => [
                'id'    => $this->tags['shop_id'] ?? null,
                'email' => $configurationPsShopEmail,
            ],
            'exception'   => [
                'values' => [[
                    'type'       => get_class($exception),
                    'value'      => $exception->getMessage(),
                    'stacktrace' => [
                        'frames' => $this->buildFrames($exception->getTrace()),
                    ],
                ]],
            ],
            'extra'       => [
                'code'    => $exception->getCode(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
            ],
            'timestamp'   => gmdate('Y-m-d\TH:i:s\Z'),
        ];

        $client = \PrestaShop\Module\PsEventbus\Api\HttpClient::getInstance()->post(
            $this->sentryUrl,
            [
                'Authorization' => 'Sentry sentry_version=7, sentry_client=ps_eventbus/1.0, sentry_key=' . $this->sentryKey,
                'Content-Type'  => 'application/json',
            ],
            $event
        );
    }


    private function buildFrames(array $trace): array
    {
        $frames = [];
        foreach (array_reverse($trace) as $t) {
            $file = $t['file'] ?? null;
            $line = (int)($t['line'] ?? 0);

            // 1) Variables/args (scrub + truncate)
            $vars = [];
            if (!empty($t['args'])) {
                foreach ($t['args'] as $i => $arg) {
                    $vars['arg' . $i] = $this->scrubAndNormalize($arg);
                }
            }

            // 2) Contexte de code (quelques lignes autour)
            [$contextLine, $pre, $post] = $this->getCodeContext($file, $line, 3);

            $frames[] = [
                'filename'     => $file ?: '<internal>',
                'lineno'       => $line,
                'function'     => $t['function'] ?? '',
                'in_app'       => $this->isInApp($file),
                'vars'         => $vars ?: null,
                'context_line' => $contextLine,
                'pre_context'  => $pre ?: null,
                'post_context' => $post ?: null,
            ];
        }
        return $frames;
    }

    private function isInApp(?string $file): bool
    {
        if (!$file) return false;
        // Marque les fichiers du module comme "in_app" pour un rendu plus lisible
        return (bool)preg_match('#/modules/ps_eventbus/#', $file);
    }

    private function getCodeContext(?string $file, int $line, int $radius = 3): array
    {
        if (!$file || $line <= 0 || !is_readable($file)) {
            return [null, [], []];
        }
        $lines = @file($file, FILE_IGNORE_NEW_LINES);
        if (!$lines) return [null, [], []];

        $idx = $line - 1;
        $start = max(0, $idx - $radius);
        $end   = min(count($lines) - 1, $idx + $radius);

        $pre  = array_slice($lines, $start, max(0, $idx - $start));
        $curr = $lines[$idx] ?? null;
        $post = array_slice($lines, $idx + 1, max(0, $end - $idx));

        // Limite de taille brutale pour ne pas dépasser la taille d’événement
        $truncate = function ($s) {
            return mb_strimwidth((string)$s, 0, 500, '…');
        };
        $pre  = array_map($truncate, $pre);
        $curr = $curr ? $truncate($curr) : null;
        $post = array_map($truncate, $post);

        return [$curr, $pre, $post];
    }

    private function scrubAndNormalize($value, int $depth = 0)
    {
        if ($depth > 3) { // évite les structures gigantesques
            return '/* depth limit */';
        }

        // Types scalaires
        if (is_null($value) || is_bool($value) || is_int($value) || is_float($value)) {
            return $value;
        }
        if (is_string($value)) {
            // Tronque les très longues chaînes
            if (strlen($value) > 2000) {
                return mb_substr($value, 0, 2000) . '…';
            }
            return $value;
        }

        // Objets
        if (is_object($value)) {
            // Ne pas serialiser des ressources PDO, cURL, etc.
            if ($value instanceof \Throwable) {
                return sprintf('Throwable(%s): %s', get_class($value), $value->getMessage());
            }
            // Représentation simple des objets
            $out = ['__class' => get_class($value)];
            // Tente d’extraire les propriétés publiques
            foreach (get_object_vars($value) as $k => $v) {
                $out[$k] = $this->scrubAndNormalize($v, $depth + 1);
            }
            return $out;
        }

        // Tableaux
        if (is_array($value)) {
            // Scrub de clés sensibles
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
            // Limite de taille du tableau
            if (count($out) > 50) {
                $out = array_slice($out, 0, 50, true) + ['__truncated' => '…'];
            }
            return $out;
        }

        // Ressources
        if (is_resource($value)) {
            return sprintf('resource(%s)', get_resource_type($value));
        }

        return '(unserializable)';
    }


    private function __clone() {}
}
