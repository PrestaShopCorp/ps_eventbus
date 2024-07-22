<?php

namespace PrestaShop\Module\PsEventbus\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class CacheService
{
    /**
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function setCacheProperty($key, $value)
    {
        $cache = new FilesystemAdapter();
        $cacheItem = $cache->getItem($key);
        $cacheItem->set($value);
        $cache->save($cacheItem);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getCacheProperty($key)
    {
        $cache = new FilesystemAdapter();
        $cacheItem = $cache->getItem($key);

        return $cacheItem->get();
    }
}
