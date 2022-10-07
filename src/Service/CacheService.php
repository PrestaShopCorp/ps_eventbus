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
        $merchantConsentCache = $cache->getItem($key);
        $merchantConsentCache->set($value);
        $cache->save($merchantConsentCache);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getCacheProperty($key)
    {
        $cache = new FilesystemAdapter();
        $merchantConsentCache = $cache->getItem($key);

        return $merchantConsentCache->get();
    }
}
