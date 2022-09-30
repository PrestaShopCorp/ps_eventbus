<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Context;
use Db;
use DbQuery;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Service\CacheService;

class MerchantConsentRepository
{
    /**
     * @var Db
     */
    private $db;
    /**
     * @var CacheService
     */
    private $cacheService;

    public function __construct(
        Db $db,
        CacheService $cacheService
    ) {
        $this->db = $db;
        $this->cacheService = $cacheService;
    }

    /**
     * @param array $value
     *
     * @return array
     */
    public function postMerchantConsent(array $value)
    {
        $dbh = $this->db->connect();

        $query = $dbh->prepare('INSERT INTO ps_merchant_consent (shop_id, module_consent, shop_consent_accepted, shop_consent_revoked) 
        VALUES (:shop_id, :module_consent, :accepted, :revoked)');

        $query->bindParam(':shop_id', $value['shop_id']);
        $query->bindParam(':module_consent', $value['module_consent']);
        $query->bindParam(':accepted', $value['accepted']);
        $query->bindParam(':revoked', $value['revoked']);

        $this->cacheService->setCacheProperty('merchantConsent.shopId', Context::getContext()->shop->id);
        $this->cacheService->setCacheProperty('merchantConsent.moduleConsent', $value['module_consent']);
        $this->cacheService->setCacheProperty('merchantConsent.accepted', $value['accepted']);
        $this->cacheService->setCacheProperty('merchantConsent.revoked', $value['revoked']);

        $query->execute();

        return $this->getMerchantConsent();
    }

    /**
     * @param int $idShop
     *
     * @return array
     *
     * @throws \PrestaShopDatabaseException
     */
    public function getConsentByShopId(int $idShop = 0)
    {
        $query = new DbQuery();

        $query->select('*')
            ->from('merchant_consent')
            ->where("shop_id='" . $idShop > 0 ? $idShop : Context::getContext()->shop->id . "'");

        return $this->db->executeS($query);
    }

    /**
     * @return array
     */
    public function getMerchantConsent()
    {
        $value = current($this->getConsentByShopId());

        return [
                'id' => $value['id'],
                'collection' => Config::COLLECTION_MERCHANT_CONSENT,
                'properties' => [
                    'created-at' => $value['created_at'],
                    'updated-at' => $value['updated_at'],
                    'module-name' => $value['module_consent'],
                    'shop-consent-revoked' => json_decode($value['shop_consent_revoked']),
                    'shop-consent-accepted' => json_decode($value['shop_consent_accepted']),
                    'id-shop' => $value['shop_id'],
                ],
        ];
    }
}
