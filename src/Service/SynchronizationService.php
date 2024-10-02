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

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Api\LiveSyncApiClient;
use PrestaShop\Module\PsEventbus\Decorator\PayloadDecorator;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\IncrementalSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\LiveSyncRepository;
use PrestaShop\Module\PsEventbus\Service\ShopContent\LanguagesService;
use PrestaShop\Module\PsEventbus\Service\ShopContent\ShopContentServiceInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

if (!defined('_PS_VERSION_')) {
    exit;
}

class SynchronizationService
{
    /**
     * @var EventbusSyncRepository
     */
    private $eventbusSyncRepository;

    /**
     * @var IncrementalSyncRepository
     */
    private $incrementalSyncRepository;

    /**
     * @var LiveSyncRepository
     */
    private $liveSyncRepository;

    /**
     * @var LanguagesService
     */
    private $languagesService;

    /**
     * @var PayloadDecorator
     */
    private $payloadDecorator;

    /**
     * @var ProxyServiceInterface
     */
    private $proxyService;

    public function __construct(
        EventbusSyncRepository $eventbusSyncRepository,
        IncrementalSyncRepository $incrementalSyncRepository,
        LiveSyncRepository $liveSyncRepository,
        LanguagesService $languagesService,
        ProxyServiceInterface $proxyService,
        PayloadDecorator $payloadDecorator
    ) {
        $this->eventbusSyncRepository = $eventbusSyncRepository;
        $this->incrementalSyncRepository = $incrementalSyncRepository;
        $this->liveSyncRepository = $liveSyncRepository;
        $this->languagesService = $languagesService;
        $this->proxyService = $proxyService;
        $this->payloadDecorator = $payloadDecorator;
    }

    /**
     * @param string $shopContent
     * @param string $jobId
     * @param string $langIso
     * @param int $offset
     * @param int $limit
     * @param int $startTime
     * @param string $dateNow
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @@throws PrestaShopDatabaseException|EnvVarException|ApiException
     */
    public function sendFullSync(
        string $shopContent,
        string $jobId,
        string $langIso,
        int $offset,
        int $limit,
        int $startTime,
        string $dateNow,
        bool $debug
    ) {
        $response = [];

        $serviceName = str_replace('_', '', ucwords($shopContent, '_'));
        $serviceId = 'PrestaShop\Module\PsEventbus\Service\ShopContent\\' . $serviceName . 'Service'; // faire un mapping entre le service et le nom du shopcontent

        /** @var \Ps_eventbus */
        $module = \Module::getInstanceByName('ps_eventbus');

        if (!$module->hasService($serviceId)) {
            throw new ServiceNotFoundException($serviceId);
        }

        /** @var ShopContentServiceInterface $shopContentApiService */
        $shopContentApiService = $module->getService($serviceId);

        $timezone = (string) \Configuration::get('PS_TIMEZONE');
        $dateNow = (new \DateTime('now', new \DateTimeZone($timezone)))->format(Config::MYSQL_DATE_FORMAT);

        $data = $shopContentApiService->getContentsForFull($offset, $limit, $langIso, $debug);

        $this->payloadDecorator->convertDateFormat($data);

        if (!empty($data)) {
            $response = $this->proxyService->upload($jobId, $data, $startTime, true);

            if ($response['httpCode'] == 201) {
                $offset += $limit;
            }
        }

        $remainingObjects = (int) $shopContentApiService->getFullSyncContentLeft($offset, $limit, $langIso);

        if ($remainingObjects <= 0) {
            $remainingObjects = 0;
            $offset = 0;
        }

        $this->eventbusSyncRepository->upsertTypeSync($shopContent, $offset, $dateNow, $remainingObjects === 0, $langIso);

        return $this->returnSyncResponse($data, $response, $remainingObjects);
    }

    /**
     * @param string $shopContent
     * @param string $jobId
     * @param string $langIso
     * @param int $limit
     * @param int $startTime
     * @param bool $debug
     *
     * @return array<mixed>
     *
     * @@throws PrestaShopDatabaseException|EnvVarException
     */
    public function sendIncrementalSync(
        string $shopContent,
        string $jobId,
        string $langIso,
        int $limit,
        int $startTime,
        bool $debug
    ) {
        $response = [];

        $serviceName = str_replace('_', '', ucwords($shopContent, '_'));
        $serviceId = 'PrestaShop\Module\PsEventbus\Service\ShopContent\\' . $serviceName . 'Service';

        /** @var \Ps_eventbus */
        $module = \Module::getInstanceByName('ps_eventbus');

        if (!$module->hasService($serviceId)) {
            throw new ServiceNotFoundException($serviceId);
        }

        /** @var ShopContentServiceInterface $shopContentApiService */
        $shopContentApiService = $module->getService($serviceId);

        $contentIds = $this->incrementalSyncRepository->getIncrementalSyncObjectIds($shopContent, $langIso, $limit);

        if (empty($contentIds)) {
            return [
                'total_objects' => 0,
                'has_remaining_objects' => false,
                'remaining_objects' => 0,
            ];
        }

        $data = $shopContentApiService->getContentsForIncremental($limit, $contentIds, $langIso, $debug);

        $this->payloadDecorator->convertDateFormat($data);

        if (!empty($data)) {
            $response = $this->proxyService->upload($jobId, $data, $startTime, false);

            if ($response['httpCode'] == 201) {
                $this->incrementalSyncRepository->removeIncrementalSyncObjects($shopContent, $contentIds, $langIso);
            }
        } else {
            $this->incrementalSyncRepository->removeIncrementalSyncObjects($shopContent, $contentIds, $langIso);
        }

        $remainingObjects = $this->incrementalSyncRepository->getRemainingIncrementalObjects($shopContent, $langIso);

        return $this->returnSyncResponse($data, $response, $remainingObjects);
    }

    /**
     * liveSync
     *
     * @param string $shopContent
     * @param int $shopContentIds
     * @param string $action
     *
     * @return void
     */
    public function sendLiveSync($shopContent, $shopContentIds, $action)
    {
        $defaultIsoCode = $this->languageRepository->getDefaultLanguageIsoCode();

        if ($this->isFullSyncDone($shopContent, $defaultIsoCode) && $this->debounceLiveSync($shopContent)) {
            try {
                /** @var LiveSyncApiClient $liveSyncApiClient */
                $liveSyncApiClient = $this->module->getService('PrestaShop\Module\PsEventbus\Api\LiveSyncApiClient');

                $liveSyncApiClient->liveSync($shopContent, (int) $shopContentId, $action);
            } catch (\Exception $e) {
                // FIXME : report this error somehow
            }
        }
    }

    /**
     * @param array<string, int> $contentTypesWithIds
     * @param string $actionType
     * @param string $createdAt
     * @param int $shopId
     * @param bool $hasMultiLang
     *
     * @return void
     */
    public function insertContentIntoIncremental($contentTypesWithIds, $actionType, $createdAt, $shopId, $hasMultiLang)
    {
        if (count($contentTypesWithIds) == 0) {
            return;
        }

        /*
         * randomly check if outbox for this shop-content contain more of 100k entries.
         * When random number == 10, we count number of entry exist in database for this specific shop content
         * If count > 100 000, we removed all entry corresponding to this shop content, and we enable full sync for this
         */
        if (mt_rand() % Config::RANDOM_SYNC_CHECK_MAX == 0) {
            foreach ($contentTypesWithIds as $contentType => $contentIds) {
                $count = $this->incrementalSyncRepository->getIncrementalSyncObjectCountByType($contentType);

                if ($count > Config::INCREMENTAL_SYNC_MAX_ITEMS_PER_SHOP_CONTENT) {
                    $hasDeleted = $this->incrementalSyncRepository->removeIncrementaSyncObjectByType($contentType);

                    if ($hasDeleted) {
                        $this->eventbusSyncRepository->upsertTypeSync(
                            $contentType,
                            0,
                            $createdAt,
                            false,
                            $this->languagesService->getDefaultLanguageIsoCode()
                        );
                    }
                }

                return;
            }
        }

        $contentToInsert = [];

        if ($hasMultiLang) {
            $allIsoCodes = $this->languagesService->getLanguagesIsoCodes();

            foreach ($allIsoCodes as $langIso) {
                foreach ($contentTypesWithIds as $contentType => $contentId) {
                    if ($this->isFullSyncDone($contentType, $langIso)) {
                        array_push($contentToInsert,
                            [
                                'type' => $contentType,
                                'id_object' => $contentId,
                                'id_shop' => $shopId,
                                'lang_iso' => $langIso,
                                'action' => $actionType,
                                'created_at' => $createdAt,
                            ]
                        );
                    }
                }
            }
        } else {
            $defaultIsoCode = $this->languagesService->getDefaultLanguageIsoCode();

            foreach ($contentTypesWithIds as $contentType => $contentId) {
                if ($this->isFullSyncDone($contentType, $defaultIsoCode)) {
                    array_push($contentToInsert,
                        [
                            'type' => $contentType,
                            'id_object' => $contentId,
                            'id_shop' => $shopId,
                            'lang_iso' => $defaultIsoCode,
                            'action' => $actionType,
                            'created_at' => $createdAt,
                        ]
                    );
                }
            }
        }

        if (empty($contentToInsert) == false) {
            $this->incrementalSyncRepository->insertIncrementalObject($contentToInsert);
        }
    }

    /**
     * @param string $shopContentName
     *
     * @return bool
     *
     * @@throws PrestaShopDatabaseException
     */
    private function debounceLiveSync($shopContentName) // @phpstan-ignore method.unused
    {
        $dateNow = date('Y-m-d H:i:s');

        $shopContent = $this->liveSyncRepository->getShopContentInfo($shopContentName);

        $lastChangeAt = $shopContent != null ? (string) $shopContent['last_change_at'] : (string) $dateNow;
        $diff = strtotime((string) $dateNow) - strtotime((string) $lastChangeAt);

        if ($shopContent == null || $diff > 60 * 5) {
            $this->liveSyncRepository->upsertDebounce($shopContentName, $dateNow);

            return true;
        }

        return false;
    }

    /**
     * Return true if full sync is done for this shop content
     *
     * @param string $shopContent
     * @param string $langIso
     *
     * @return bool
     */
    private function isFullSyncDone($shopContent, $langIso)
    {
        return $this->eventbusSyncRepository->isFullSyncDoneForThisTypeSync($shopContent, $langIso);
    }

    /**
     * @param array<mixed> $data
     * @param array<mixed> $syncResponse
     * @param int $remainingObjects
     *
     * @return array<mixed>
     */
    private function returnSyncResponse($data, $syncResponse, $remainingObjects)
    {
        return array_merge([
            'total_objects' => count($data),
            'has_remaining_objects' => $remainingObjects > 0,
            'remaining_objects' => $remainingObjects,
            'md5' => $this->getPayloadMd5($data),
        ], $syncResponse);
    }

    /**
     * @param array<mixed> $payload
     *
     * @return string
     */
    private function getPayloadMd5($payload)
    {
        return md5(
            implode(' ', array_map(function ($payloadItem) {
                return $payloadItem['id'];
            }, $payload))
        );
    }
}
