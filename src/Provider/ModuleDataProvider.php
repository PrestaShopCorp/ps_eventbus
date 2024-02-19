<?php

namespace PrestaShop\Module\PsEventbus\Provider;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Repository\ModuleRepository;
use PrestaShop\Module\PsEventbus\Repository\ShopRepository;

class ModuleDataProvider implements PaginatedApiDataProviderInterface
{
    /**
     * @var ModuleRepository
     */
    private $moduleRepository;

    /**
     * @var string
     */
    private $createdAt;

    public function __construct(ModuleRepository $moduleRepository, ShopRepository $shopRepository)
    {
        $this->moduleRepository = $moduleRepository;
        $this->createdAt = $shopRepository->getCreatedAt();
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     */
    public function getFormattedData($offset, $limit, $langIso)
    {
        $modules = $this->moduleRepository->getModules($offset, $limit);

        if (!is_array($modules)) {
            return [];
        }

        return array_map(function ($module) {
            $moduleId = (string) $module['module_id'];
            $module['active'] = $module['active'] == '1';
            if (version_compare(_PS_VERSION_, '1.7', '>=')) {
                $module['created_at'] = $module['created_at'] ?: $this->createdAt;
                $module['updated_at'] = $module['updated_at'] ?: $this->createdAt;
            } else {
                $module['created_at'] = $this->createdAt;
                $module['updated_at'] = $this->createdAt;
            }

            return [
                'id' => $moduleId,
                'collection' => Config::COLLECTION_MODULES,
                'properties' => $module,
            ];
        }, $modules);
    }

    /**
     * @param int $offset
     * @param string $langIso
     *
     * @return int
     */
    public function getRemainingObjectsCount($offset, $langIso)
    {
        return (int) $this->moduleRepository->getRemainingModules($offset);
    }

    public function getFormattedDataIncremental($limit, $langIso, $objectIds)
    {
        return [];
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param string $langIso
     *
     * @return array
     *
     * @throws \PrestaShop\PrestaShop\Adapter\Entity\PrestaShopDatabaseException
     */
    public function getQueryForDebug($offset, $limit, $langIso)
    {
        return $this->moduleRepository->getQueryForDebug($offset, $limit);
    }
}
