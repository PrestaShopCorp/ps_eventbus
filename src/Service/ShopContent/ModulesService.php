<?php

namespace PrestaShop\Module\PsEventbus\Service\ShopContent;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\NewRepository\ModuleRepository;
use PrestaShop\Module\PsEventbus\Repository\ShopRepository;

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
