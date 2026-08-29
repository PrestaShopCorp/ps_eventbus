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

namespace PrestaShop\Module\PsEventbus\Service;

use Db;
use Exception;

class ShopBenchmark
{
    const MAX_TIME = 5; // Temps d'exécution
    const EXTRA_TIME = 0.15; // Temps supplémentaire

    const CPU_BENCH = 'cpu';
    const FILE_BENCH = 'file';
    const DB_BENCH = 'db';
    const NETWORK_BENCH = 'network';

    const ITEM_TYPES = [
        self::CPU_BENCH,
        self::FILE_BENCH,
        self::DB_BENCH,
        self::NETWORK_BENCH,
    ];

    /**
     * @param array $items
     * @param array $config
     * 
     * @return array
     */
    public static function runBenchmark($items)
    {
        $startTime = microtime(true);

        $result = [];

        // Nombre de tests
        $totalTests = count($items);

        if ($totalTests === 0) {
            return $result; // Aucun test à exécuter
        }

        // Calcul du temps d'exécution pour chaque test
        $testTimeout = (self::MAX_TIME - self::EXTRA_TIME) / $totalTests;

        foreach ($items as $item) {
            if (in_array($item, self::ITEM_TYPES)) {
                switch ($item) {
                    case self::CPU_BENCH:
                        $result[$item] = self::cpuBenchmark($testTimeout);
                        break;
                    case self::FILE_BENCH:
                        $result[$item] = self::fileBenchmark($testTimeout);
                        break;
                    case self::DB_BENCH:
                        $result[$item] = self::dbBenchmark($testTimeout);
                        break;
                    case self::NETWORK_BENCH:
                        $result[$item] = self::networkBenchmark($testTimeout);
                        break;
                }
            }
        }

        $result['total_execution_time'] = microtime(true) - $startTime;

        return $result;
    }

    private static function cpuBenchmark($testTimeout)
    {
        $config = [
            'max_regex_count' => 20000,
            'max_random_bytes' => 1000 * 1024 * 1024,
            'max_fibonnaci_recursive' => 35,
            'max_fibonacci_iterative' => 100000000,
            'max_floating_point_operations' => 10000000
        ];

        // we have to divide the timeout by 5 because we have 5 tests
        $timeout = $testTimeout / 5;

        return [
            'regex' => self::testCpuRegex($config['max_regex_count'], $timeout),
            'random_bytes' => self::testCpuRandomBytes($config['max_random_bytes'], $timeout),
            'fibonacci_recursive' => self::testCpuFibonacciRecursive($config['max_fibonnaci_recursive'], $timeout),
            'fibonacci_iterative' => self::testCpuFibonacciIterative($config['max_fibonacci_iterative'], $timeout),
            'floating_point' => self::testCpuFloatingPointOperations($config['max_floating_point_operations'], $timeout),
        ];
    }

    private static function fileBenchmark($testTimeout)
    {
        $startTime = microtime(true);
        $totalTime = 0;
        $count = 0;

        $config = [
            'file_size' => 1024 * 1024, // 1MB
            'repeats' => 500
        ];

        $tempFile = tempnam(sys_get_temp_dir(), 'bench_');

        try {
            while ($count < $config['repeats']) {
                $data = random_bytes($config['file_size']);

                file_put_contents($tempFile, $data);
                file_get_contents($tempFile);

                $count++;

                $totalTime = microtime(true) - $startTime;

                if ($totalTime > $testTimeout) break;
            }
        } catch (Exception $e) {
            return [
                'count' => $count,
                'max_time' => number_format(microtime(true) - $startTime, 2),
                'error' => $e->getMessage(),
            ];
        } finally {
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }

        return [
            'count' => $count,
            'repeats' => $config['repeats'],
            'file_size' => $config['file_size'],
            'max_time' => number_format($totalTime, 2) . 's'
        ];
    }

    private static function dbBenchmark($testTimeout)
    {
        $config = [
            'query' => 'SELECT 1',
            'repeats' => 100000,
        ];

        $startTime = microtime(true);
        $totalTime = 0;
        $count = 0;

        try {
            $db = Db::getInstance();

            while ($count < $config['repeats']) {
                $stmt = $db->query($config['query']);
                $stmt->fetch();

                $count++;

                $totalTime = microtime(true) - $startTime;

                if ($totalTime > $testTimeout) break;
            }
        } catch (Exception $e) {
            return [
                'count' => $count,
                'max_time' => number_format($totalTime, 2) . 's',
                'error' => $e->getMessage()
            ];
        }
        return [
            'count' => $count,
            'repeats' => $config['repeats'],
            'query' => $config['query'],
            'max_time' => number_format($totalTime, 2) . 's'
        ];
    }

    private static function networkBenchmark($testTimeout)
    {
        $config = [
            'url' => 'https://www.google.com',
            'repeats' => 100,
        ];

        $startTime = microtime(true);
        $totalTime = 0;
        $count = 0;

        try {
            while ($count < $config['repeats']) {
                $ctx = stream_context_create(['http' => ['timeout' => 1]]);
                @file_get_contents($config['url'], false, $ctx);

                $count++;

                $totalTime = microtime(true) - $startTime;

                if ($totalTime > $testTimeout) break;
            }
        } catch (Exception $e) {
            return [
                'count' => $count,
                'max_time' => number_format($totalTime, 2) . 's',
                'error' => $e->getMessage()
            ];
        }

        return [
            'count' => $count,
            'repeats' => $config['repeats'],
            'url' => $config['url'],
            'max_time' => number_format($totalTime, 2) . 's'
        ];
    }

    private static function testCpuRegex($maxIterations, $timeout)
    {
        $startTime = microtime(true);
        $totalTime = 0;
        $count = 0;

        $pattern = '/[a-z]+/i';
        $subject = str_repeat("abc def ghi jkl mno pqr stu vwx yz ", 1000);

        for ($i = 0; $i < $maxIterations; $i++) {
            preg_match_all($pattern, $subject);
            $count++;

            $totalTime = microtime(true) - $startTime;

            if ($totalTime > $timeout) break;
        }

        return [
            'count' => $count,
            'max_count' => $maxIterations,
            'max_time' => number_format($totalTime, 2) . 's',
        ];
    }

    private static function testCpuRandomBytes($maxIterations, $timeout)
    {
        $startTime = microtime(true);
        $totalTime = 0;
        $count = 0;

        $chunkSize = 1024 * 1024;

        while ($count < $maxIterations) {
            random_bytes(min($chunkSize, $maxIterations - $count));
            $count += $chunkSize;

            $totalTime = microtime(true) - $startTime;

            if ($totalTime > $timeout) break;
        }

        return [
            'count' => $count,
            'max_count' => $maxIterations,
            'max_time' => number_format($totalTime, 2) . 's',
        ];
    }

    private static function testCpuFibonacciRecursive($maxIterations, $timeout)
    {
        $startTime = microtime(true);
        $totalTime = 0;
        $count = 0;

        $fibo = function ($iterations) use (&$fibo, &$count, $startTime, $timeout, &$totalTime) {
            $count++;

            $totalTime = microtime(true) - $startTime;

            if ($totalTime > $timeout) return 0;
            if ($iterations <= 1) return $iterations;

            return $fibo($iterations - 1) + $fibo($iterations - 2);
        };

        $fibo($maxIterations);

        return [
            'count' => $count,
            'max_count' => $maxIterations,
            'max_time' => number_format($totalTime, 2) . 's',
        ];
    }

    private static function testCpuFibonacciIterative($maxIterations, $timeout)
    {
        $startTime = microtime(true);
        $totalTime = 0;
        $count = 0;

        $a = 0;
        $b = 1;

        for ($i = 0; $i < $maxIterations; $i++) {
            $c = $a + $b;
            $a = $b;
            $b = $c;

            $count++;

            $totalTime = microtime(true) - $startTime;

            if ($totalTime > $timeout) break;
        }

        return [
            'count' => $count,
            'max_count' => $maxIterations,
            'max_time' => number_format($totalTime, 2) . 's',
        ];
    }

    private static function testCpuFloatingPointOperations($maxIterations, $timeout)
    {
        $startTime = microtime(true);
        $totalTime = 0;
        $count = 0;

        $result = 0.0;

        for ($i = 0; $i < $maxIterations; $i++) {
            $result += sin($i) * cos($i);
            $count++;

            $totalTime = microtime(true) - $startTime;
            if ($totalTime > $timeout) break;
        }

        return [
            'count' => $count,
            'max_count' => $maxIterations,
            'max_time' => number_format($totalTime, 2) . 's',
        ];
    }
}
