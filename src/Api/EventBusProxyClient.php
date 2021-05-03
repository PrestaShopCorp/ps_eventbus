<?php

/**
 * 2007-2020 PrestaShop and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Post\PostFile;
use Link;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

/**
 * Construct the client used to make call to Segment API
 */
class EventBusProxyClient extends GenericClient
{
    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @param Link $link
     * @param PsAccounts $psAccountsService
     * @param string $baseUrl
     *
     * @throws \PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleNotInstalledException
     * @throws \PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleVersionException
     */
    public function __construct(Link $link, PsAccounts $psAccountsService, $baseUrl)
    {
        $this->baseUrl = $baseUrl;
        $this->setLink($link);
        $token = $psAccountsService->getPsAccountsService()->getOrRefreshToken();

        $client = new Client([
            'base_url' => $this->baseUrl,
            'defaults' => [
                'timeout' => 60,
                'exceptions' => $this->catchExceptions,
                'headers' => [
                    'Authorization' => "Bearer $token",
                ],
            ],
        ]);

        parent::__construct($client);
    }

    /**
     * @param string $jobId
     * @param string $data
     * @param int $scriptStartTime
     *
     * @return array
     */
    public function upload($jobId, $data, $scriptStartTime)
    {
        $timeout = Config::PROXY_TIMEOUT - (time() - $scriptStartTime);

        $route = $this->baseUrl . "/upload/$jobId";

        $this->setRoute($route);

        $file = new PostFile(
            'file',
            $data,
            'file'
        );

        $response = $this->post([
            'headers' => [
                'Content-Type' => 'binary/octet-stream',
            ],
            'body' => [
                'file' => $file,
            ],
            'timeout' => $timeout,
        ]);

        if (is_array($response)) {
            $response['upload_url'] = $route;
        }

        return $response;
    }

    /**
     * @param string $jobId
     * @param string $compressedData
     *
     * @return array
     */
    public function uploadDelete($jobId, $compressedData)
    {
        $route = $this->baseUrl . "/delete/$jobId";

        $this->setRoute($route);

        $file = new PostFile(
            'file',
            $compressedData,
            'file.gz'
        );

        $response = $this->post([
            'headers' => [
                'Content-Type' => 'binary/octet-stream',
            ],
            'body' => [
                'file' => $file,
            ],
        ]);

        if (is_array($response)) {
            $response['upload_url'] = $route;
        }

        return $response;
    }
}
