<?php

namespace PrestaShop\Module\PsEventbus\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class CacheService
{

    public function setMerchantCacheProperty($key, $value)
    {
        $cache = new FilesystemAdapter();
        $merchantConsentCache = $cache->getItem($key);
        $merchantConsentCache->set($value);
        $cache->save($merchantConsentCache);
    }

    public function getMerchantCacheProperty($key)
    {
        $cache = new FilesystemAdapter();
        $merchantConsentCache = $cache->getItem($key);

        return $merchantConsentCache->get();
    }

}