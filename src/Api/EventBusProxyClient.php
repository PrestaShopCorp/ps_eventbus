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

use PrestaShop\Module\PsEventbus\Api\Post\MultipartBody;
use PrestaShop\Module\PsEventbus\Api\Post\PostFileApi;
use PrestaShop\Module\PsEventbus\Config\Config;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleNotInstalledException;
use PrestaShop\PsAccountsInstaller\Installer\Exception\ModuleVersionException;
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
     * @var \Ps_eventbus
     */
    private $module;

    /**
     * @param \Link $link
     * @param PsAccounts $psAccounts
     * @param string $baseUrl
     * @param \Ps_eventbus $module
     *
     * @throws ModuleNotInstalledException
     * @throws ModuleVersionException
     * @throws \Exception
     */
    public function __construct(\Link $link, PsAccounts $psAccounts, $baseUrl, $module)
    {
        $this->module = $module;
        $this->baseUrl = $baseUrl;
        $this->setLink($link);
        $token = $psAccounts->getPsAccountsService()->getOrRefreshToken();

        $options = [
            'base_uri' => $this->baseUrl,
            'timeout' => 60,
            'http_errors' => $this->catchExceptions,
            'headers' => ['authorization' => "Bearer $token"],
        ];

        $client = (new ClientFactory())->getClient($options);

        parent::__construct($client, $options);
    }

    /**
     * @param string $jobId
     * @param string $data
     * @param int $scriptStartTime
     * @param bool $isFull
     *
     * @return array
     */
    public function upload(string $jobId, string $data, int $scriptStartTime, bool $isFull = false)
    {
        $timeout = Config::PROXY_TIMEOUT - (time() - $scriptStartTime);

        $route = $this->baseUrl . "/upload/$jobId";

        $this->setRoute($route);

        $file = new PostFileApi('file', $data, 'file');

        $multipartBody = new MultipartBody([], [$file], 'ps_eventbus_boundary');

        $response = $this->post([
            'headers' => [
                'Content-Type' => 'multipart/form-data; boundary=ps_eventbus_boundary',
                'ps-eventbus-version' => $this->module->version,
                'full' => $isFull ? '1' : '0',
                'Content-Length' => $file->getContent()->getSize(),
                'timeout' => $timeout,
            ],
            'body' => $multipartBody->getContents(),
        ]);

        if (is_array($response)) {
            $response['upload_url'] = $route;
        }

        return $response;
    }

    /**
     * @param string $jobId
     * @param string $compressedData
     * @param int $scriptStartTime
     *
     * @return array
     */
    public function uploadDelete(string $jobId, string $compressedData, int $scriptStartTime)
    {
        $timeout = Config::PROXY_TIMEOUT - (time() - $scriptStartTime);

        $route = $this->baseUrl . "/delete/$jobId";

        $this->setRoute($route);

        $file = new PostFileApi(
            'file',
            $compressedData,
            'file'
        );

        $multipartBody = new MultipartBody([], [$file], 'ps_eventbus_boundary');

        $response = $this->post([
            'headers' => [
                'Content-Type' => 'multipart/form-data; boundary=ps_eventbus_boundary',
                'ps-eventbus-version' => $this->module->version,
                'Content-Length' => $file->getContent()->getSize(),
                'timeout' => $timeout,
            ],
            'body' => $multipartBody->getContents(),
        ]);

        if (is_array($response)) {
            $response['upload_url'] = $route;
        }

        return $response;
    }
}
