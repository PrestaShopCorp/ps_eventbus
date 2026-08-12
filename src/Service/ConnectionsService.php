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

use PrestaShop\Module\PsEventbus\Api\CloudSyncClient;
use PrestaShop\Module\PsEventbus\Helper\ModuleHelper;

if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Builds the read-only list of services connected to the shop, as displayed on
 * the Connections page.
 *
 * The Sync API only knows module names. The human readable name and the logo
 * come from the shop itself, when the module happens to be installed.
 */
class ConnectionsService
{
    /**
     * @var CloudSyncClient
     */
    private $cloudSyncClient;

    /**
     * @var ModuleHelper
     */
    private $moduleHelper;

    /**
     * Public URL of the shop's modules directory, with a trailing slash.
     *
     * @var string
     */
    private $modulesBaseUrl;

    /**
     * @param CloudSyncClient $cloudSyncClient
     * @param ModuleHelper $moduleHelper
     * @param string $modulesBaseUrl
     */
    public function __construct(
        CloudSyncClient $cloudSyncClient,
        ModuleHelper $moduleHelper,
        $modulesBaseUrl
    ) {
        $this->cloudSyncClient = $cloudSyncClient;
        $this->moduleHelper = $moduleHelper;
        $this->modulesBaseUrl = $modulesBaseUrl;
    }

    /**
     * @return array<int, array<string, mixed>>
     *
     * @throws \Exception
     */
    public function getConnections()
    {
        $services = [];

        foreach ($this->cloudSyncClient->getShopConsents() as $item) {
            if (!is_array($item) || empty($item['moduleName'])) {
                continue;
            }

            $services[] = $this->describe($item);
        }

        usort($services, [$this, 'compare']);

        return $services;
    }

    /**
     * @param array<string, mixed> $item
     *
     * @return array<string, mixed>
     */
    private function describe($item)
    {
        $moduleName = (string) $item['moduleName'];
        $module = $this->moduleHelper->getInstanceByName($moduleName);
        $installed = $module !== false && !empty($module->displayName);

        return [
            'moduleName' => $moduleName,
            'displayName' => $installed ? (string) $module->displayName : $moduleName,
            'logoUrl' => $installed ? $this->modulesBaseUrl . $moduleName . '/logo.png' : null,
            'consents' => isset($item['consents']) && is_array($item['consents']) ? array_values($item['consents']) : [],
            'revokedAt' => empty($item['revokedAt']) ? null : (string) $item['revokedAt'],
        ];
    }

    /**
     * Active services first, revoked ones last, alphabetical within each group.
     *
     * @param array<string, mixed> $left
     * @param array<string, mixed> $right
     *
     * @return int
     */
    private function compare($left, $right)
    {
        $leftRevoked = $left['revokedAt'] === null ? 0 : 1;
        $rightRevoked = $right['revokedAt'] === null ? 0 : 1;

        if ($leftRevoked !== $rightRevoked) {
            return $leftRevoked - $rightRevoked;
        }

        return strcasecmp($left['displayName'], $right['displayName']);
    }
}
