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

use PrestaShop\Module\PsEventbus\Service\PsAccountsAdapterService;

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
     * @param string $shopContent
     * @param string $action
     *
     * @return array<mixed>
     */
    public function liveSync($shopContent, $action)
    {
        // shop content send to the API must be in kebab-case
        $kebabCasedShopContent = str_replace('_', '-', $shopContent);

        $client = new HttpClientFactory(3);

        $response = $client->sendRequest(
            'POST',
            $this->liveSyncApiUrl . '/notify/' . $this->shopId,
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->jwt,
                'User-Agent' => 'ps-eventbus/' . $this->module->version,
                'Content-Type' => 'application/json',
            ],
            '{"shopContents": ["' . $kebabCasedShopContent . '"], "action": "' . $action . '"}'
        );

        return [
            'status' => substr((string) $response->getStatusCode(), 0, 1) === '2',
            'httpCode' => $response->getStatusCode(),
            'body' => $response->getContent(),
        ];
    }
}
