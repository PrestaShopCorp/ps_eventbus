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
 * The only outbound network calls the system diagnostic makes.
 *
 * Kept in a class of its own so the diagnostic itself stays a pure assembly of
 * values and can be tested without touching the network.
 *
 * Both probes report a failure rather than raising it: a diagnostic page that
 * cannot answer one line is still useful, one that returns HTTP 500 is not.
 */
class NetworkProbe
{
    /**
     * Short enough that an unreachable endpoint does not hold the whole
     * diagnostic hostage, long enough to survive a slow but working link.
     */
    const DEFAULT_TIMEOUT = 5;

    /**
     * Whether an HTTP endpoint answers at all.
     *
     * Any HTTP status counts as reachable, including 4xx: the question asked is
     * whether the shop can get out to CloudSync, not whether the request was
     * well formed.
     *
     * @param string $url
     * @param int $timeout
     *
     * @return array{reachable: bool, httpStatus: int|null, error: string|null}
     */
    public function ping($url, $timeout = self::DEFAULT_TIMEOUT)
    {
        if ($url === '') {
            return ['reachable' => false, 'httpStatus' => null, 'error' => 'No endpoint URL is configured'];
        }

        if (!function_exists('curl_init')) {
            return ['reachable' => false, 'httpStatus' => null, 'error' => 'cURL extension is not available'];
        }

        $handle = curl_init();

        if ($handle === false) {
            return ['reachable' => false, 'httpStatus' => null, 'error' => 'Could not initialize cURL'];
        }

        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_NOBODY, true);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($handle, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 2);

        curl_exec($handle);

        $errorMessage = curl_error($handle);
        $httpStatus = (int) curl_getinfo($handle, CURLINFO_HTTP_CODE);

        curl_close($handle);

        if ($errorMessage !== '') {
            return ['reachable' => false, 'httpStatus' => null, 'error' => $errorMessage];
        }

        if ($httpStatus === 0) {
            return ['reachable' => false, 'httpStatus' => null, 'error' => 'No response from the endpoint'];
        }

        return ['reachable' => true, 'httpStatus' => $httpStatus, 'error' => null];
    }

    /**
     * Inspects the TLS certificate a host serves.
     *
     * `valid` is null when nothing could be established — an unreachable host
     * says nothing about its certificate, and reporting "invalid" there would
     * send the merchant after the wrong problem.
     *
     * @param string $host
     * @param int $port
     * @param int $timeout
     *
     * @return array{valid: bool|null, expiresAt: string|null, error: string|null}
     */
    public function inspectCertificate($host, $port = 443, $timeout = self::DEFAULT_TIMEOUT)
    {
        $unknown = ['valid' => null, 'expiresAt' => null, 'error' => null];

        if ($host === '') {
            return array_merge($unknown, ['error' => 'No shop domain to check']);
        }

        if (!function_exists('stream_socket_client') || !in_array('ssl', stream_get_transports(), true)) {
            return array_merge($unknown, ['error' => 'SSL stream transport is not available']);
        }

        $context = stream_context_create([
            'ssl' => [
                'capture_peer_cert' => true,
                'verify_peer' => true,
                'verify_peer_name' => true,
                'SNI_enabled' => true,
                'peer_name' => $host,
            ],
        ]);

        $errorCode = 0;
        $errorMessage = '';

        // Verification failures surface as a connection error, which is exactly
        // the answer we want: a certificate the shop's own PHP refuses is a
        // certificate CloudSync will refuse too.
        $client = @stream_socket_client(
            'ssl://' . $host . ':' . $port,
            $errorCode,
            $errorMessage,
            $timeout,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if ($client === false) {
            return ['valid' => false, 'expiresAt' => null, 'error' => $errorMessage !== '' ? $errorMessage : 'Could not establish a TLS connection'];
        }

        $params = stream_context_get_params($client);
        fclose($client);

        if (empty($params['options']['ssl']['peer_certificate'])) {
            return array_merge($unknown, ['error' => 'No certificate was presented']);
        }

        $certificate = openssl_x509_parse($params['options']['ssl']['peer_certificate']);

        if (!is_array($certificate) || empty($certificate['validTo_time_t'])) {
            return array_merge($unknown, ['error' => 'Certificate could not be parsed']);
        }

        $expiresAt = (int) $certificate['validTo_time_t'];

        return [
            'valid' => $expiresAt > time(),
            'expiresAt' => date('c', $expiresAt),
            'error' => $expiresAt > time() ? null : 'Certificate has expired',
        ];
    }
}
