<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Context;
use Db;
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
        /* @var \PDO $dbh */
        $dbh = $this->db->connect();

        /* @var \PDO $query */
        $query = $dbh->prepare('INSERT INTO ps_eventbus_merchant_consents (shop_id, module_consent, shop_consent_accepted, shop_consent_revoked)
        VALUES (:shop_id, :module_consent, :accepted, :revoked) 
        ON DUPLICATE KEY UPDATE shop_consent_accepted = :accepted, shop_consent_revoked = :revoked, updated_at = NOW()');
        // FIXME each request increment the id index of the table but does not create a new row

        $query->bindParam(':shop_id', $value['shop_id']);
        $query->bindParam(':module_consent', $value['module_consent']);
        $query->bindParam(':accepted', $value['accepted']);
        $query->bindParam(':revoked', $value['revoked']);

        $this->cacheService->setCacheProperty('merchantConsent.shopId', (string) $value['shop_id']);
        $this->cacheService->setCacheProperty('merchantConsent.moduleConsent', $value['module_consent']);
        $this->cacheService->setCacheProperty('merchantConsent.accepted', $value['accepted']);
        $this->cacheService->setCacheProperty('merchantConsent.revoked', $value['revoked']);

        $query->execute();

        return $this->getMerchantConsent($value['module_consent']);
    }

    /**
     * @param int $idShop
     * @param string $moduleName
     *
     * @return array|false
     *
     * @throws \PrestaShopDatabaseException
     */
    private function getConsentByShopIdAndModuleName(string $moduleName, int $idShop)
    {
        /* @var \PDO $dbh */
        $dbh = $this->db->connect();

        /* @var \PDO $query */
        $query = $dbh->prepare('SELECT * FROM ps_eventbus_merchant_consents WHERE shop_id = :shop_id AND module_consent LIKE :module_consent LIMIT 1');

        $query->execute(['shop_id' => $idShop, 'module_consent' => $moduleName]);

        /* @phpstan-ignore-next-line */
        return $query->fetch();
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getMerchantConsent(string $moduleName, int $idShop = 0)
    {
        $value = $this->getConsentByShopIdAndModuleName($moduleName, $idShop > 0 ? $idShop : (int) Context::getContext()->shop->id);
        if ($value === false) {
            throw new \Exception('No merchant consent found');
        }

        return [
            'id' => $value['id'],
            'created-at' => $value['created_at'],
            'updated-at' => $value['updated_at'],
            'module-name' => $value['module_consent'],
            'shop-consent-revoked' => json_decode($value['shop_consent_revoked']),
            'shop-consent-accepted' => json_decode($value['shop_consent_accepted']),
            'id-shop' => $value['shop_id'],
        ];
    }
}
