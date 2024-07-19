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
        $filesystemAdapter = new FilesystemAdapter();
        $cacheItem = $filesystemAdapter->getItem($key);
        $cacheItem->set($value);
        $filesystemAdapter->save($cacheItem);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getCacheProperty($key)
    {
        $filesystemAdapter = new FilesystemAdapter();
        $cacheItem = $filesystemAdapter->getItem($key);

        return $cacheItem->get();
    }
}
