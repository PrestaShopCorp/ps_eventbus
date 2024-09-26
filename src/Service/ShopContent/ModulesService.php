<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ModuleRepository;
use PrestaShop\Module\PsEventbus\Repository\ShopRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ModulesService implements ShopContentServiceInterface
{
    /** @var ModuleRepository */
    private $moduleRepository;

    /** @var ShopRepository */
    private $shopRepository;

    public function __construct(
        ModuleRepository $moduleRepository,
        ShopRepository $shopRepository
    ) {
        $this->moduleRepository = $moduleRepository;
        $this->shopRepository = $shopRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso, $debug)
    {
        $result = $this->moduleRepository->retrieveContentsForFull($offset, $limit, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castModules($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['module_id'],
                'collection' => Config::COLLECTION_MODULES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<string, int> $contentIds
     * @param string $langIso
     * @param bool $debug
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $contentIds, $langIso, $debug)
    {
        $result = $this->moduleRepository->retrieveContentsForIncremental($limit, $contentIds, $langIso, $debug);

        if (empty($result)) {
            return [];
        }

        $this->castModules($result);

        return array_map(function ($item) {
            return [
                'id' => (string) $item['module_id'],
                'collection' => Config::COLLECTION_MODULES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return int
     */
    public function getFullSyncContentLeft($offset, $limit, $langIso)
    {
        return $this->moduleRepository->countFullSyncContentLeft($offset, $limit, $langIso);
    }

    /**
     * @param array<mixed> $modules
     *
     * @return void
     */
    private function castModules(&$modules)
    {
        $shopCreatedAt = $this->shopRepository->getCreatedAt();

        foreach ($modules as &$module) {
            $module['module_id'] = (string) $module['module_id'];
            $module['active'] = $module['active'] == '1';
            $module['created_at'] = $module['created_at'] ?: $shopCreatedAt;
            $module['updated_at'] = $module['updated_at'] ?: $shopCreatedAt;
        }
    }
}
