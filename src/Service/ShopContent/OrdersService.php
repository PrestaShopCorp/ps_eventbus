<?php

namespace PrestaShop\Module\PsEventbus\Services;

use PrestaShop\Module\PsEventbus\Interfaces\ShopContentServiceInterface;
use PrestaShop\Module\PsEventbus\Repository\OrdersRepository;

class OrdersService implements ShopContentServiceInterface
{
    /** @var OrdersRepository $ordersRepository */
    private $ordersRepository;

    public function __construct(OrdersRepository $ordersRepository)
    {
        $this->ordersRepository = $ordersRepository;
    }

    public function getContentsForFull($offset, $limit, $langIso = null, $debug = false) {
        $result = $this->ordersRepository->getContentsForFull($offset, $limit, $langIso, $debug);

        return $result;
    }

    public function getContentsForIncremental($limit, $contentIds, $langIso = null, $debug = false) {
        $result = $this->ordersRepository->getContentsForIncremental($limit, $contentIds, $langIso = null, $debug);

        return $result;
    }

    public function countFullSyncContentLeft($offset, $langIso = null) {
        $result = $this->ordersRepository->countFullSyncContentLeft($offset, $langIso);

        return $result;
    }
}
