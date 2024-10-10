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

namespace PrestaShop\Module\PsEventbus\Api;

use GuzzleHttp\Psr7\Request;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;
use Prestashop\ModuleLibGuzzleAdapter\ClientFactory;
use Prestashop\ModuleLibGuzzleAdapter\Interfaces\HttpClientInterface;

if (!defined('_PS_VERSION_')) {
    exit;
}

class LiveSyncApiClient
{
    /**
     * @var string
     */
    private $liveSyncApiUrl;

    /**
     * @var \Ps_eventbus
     */
    private $module;

    /**
     * Accounts JSON Web token
     *
     * @var string
     */
    private $jwt;

    /**
     * Accounts Shop UUID
     *
     * @var string
     */
    private $shopId;

    /**
     * @param string $liveSyncApiUrl
     * @param \Ps_eventbus $module
     * @param PsAccountsAdapterService $psAccountsAdapterService
     */
    public function __construct($liveSyncApiUrl, \Ps_eventbus $module, PsAccountsAdapterService $psAccountsAdapterService)
    {
        $this->module = $module;
        $this->jwt = $psAccountsAdapterService->getOrRefreshToken();
        $this->shopId = $psAccountsAdapterService->getShopUuid();
        $this->liveSyncApiUrl = $liveSyncApiUrl;
    }

    /**
     * @see https://docs.guzzlephp.org/en/stable/quickstart.html-
     *
     * @param int $timeout
     *
     * @return HttpClientInterface
     */
    private function getClient($timeout = Config::SYNC_API_MAX_TIMEOUT)
    {
        return (new ClientFactory())->getClient([
            'allow_redirects' => true,
            'connect_timeout' => 5,
            'http_errors' => false,
            'timeout' => $timeout,
        ]);
    }

    /**
     * @param string $shopContent
     * @param string $action
     *
     * @return array<mixed>
     */
    public function liveSync($shopContent, $action)
    {
        // shop content send to the API must be in kebab-case
        $kebabCasedShopContent = str_replace('_', '-', $shopContent);

        // This parameter is purely useless, but it is required by the API
        $uselessParameter = 0;

        $response = $this->getClient(3)->sendRequest(
            new Request(
                'POST',
                $this->liveSyncApiUrl . '/notify/' . $this->shopId,
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->jwt,
                    'User-Agent' => 'ps-eventbus/' . $this->module->version,
                    'Content-Type' => 'application/json',
                ], // FIXME: Pass real array of shop contents. at the moment, only one shop content is sent to match CS rate limiter
                '{"shopContents": ["' . $kebabCasedShopContent . '"], "action": "' . $action . '"}'
            )
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
            'body' => $response->getBody(),
        ];
    }
}
