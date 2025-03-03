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

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\InfoRepository;
use PrestaShop\Module\PsEventbus\Repository\ModuleRepository;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ModulesService extends ShopContentAbstractService implements ShopContentServiceInterface
{
    /** @var ModuleRepository */
    private $moduleRepository;

    /** @var InfoRepository */
    private $infoRepository;

    public function __construct(
        ModuleRepository $moduleRepository,
        InfoRepository $infoRepository
    ) {
        $this->moduleRepository = $moduleRepository;
        $this->infoRepository = $infoRepository;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForFull($offset, $limit, $langIso)
    {
        $result = $this->moduleRepository->retrieveContentsForFull($offset, $limit, $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castModules($result);

        return array_map(function ($item) {
            return [
                'action' => Config::INCREMENTAL_TYPE_UPSERT,
                'collection' => Config::COLLECTION_MODULES,
                'properties' => $item,
            ];
        }, $result);
    }

    /**
     * @param int $limit
     * @param array<mixed> $upsertedContents
     * @param array<mixed> $deletedContents
     * @param string $langIso
     *
     * @return array<mixed>
     */
    public function getContentsForIncremental($limit, $upsertedContents, $deletedContents, $langIso)
    {
        $result = $this->moduleRepository->retrieveContentsForIncremental($limit, array_column($upsertedContents, 'id'), $langIso);

        if (empty($result)) {
            return [];
        }

        $this->castModules($result);

        return parent::formatIncrementalSyncResponse(Config::COLLECTION_MODULES, $result, $deletedContents);
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
        $shopCreatedAt = $this->infoRepository->getCreatedAt();

        foreach ($modules as &$module) {
            $module['module_id'] = (string) $module['module_id'];
            $module['active'] = $module['active'] == '1';
            $module['created_at'] = isset($module['created_at']) ? $module['created_at'] : $shopCreatedAt;
            $module['updated_at'] = isset($module['updated_at']) ? $module['updated_at'] : $shopCreatedAt;
        }
    }
}
