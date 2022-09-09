<?php

namespace PrestaShop\Module\PsEventbus\Repository;

use Context;
use Db;
use DbQuery;
use PrestaShop\Module\PsAccounts\Api\Client\AccountsClient;
use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Formatter\ArrayFormatter;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandlerInterface;
use PrestaShop\PsAccountsInstaller\Installer\Facade\PsAccounts;

class MerchantConsentRepository
{
    /**
     * @var ShopRepository
     */
    private $shopRepository;
    /**
     * @var string
     */
    private $createdAt;
    /**
     * @var string
     */
    private $updatedAt;
    /**
     * @var string
     */
    private $module;
    /**
     * @var bool
     */
    private $shopConsentRevoked;
    /**
     * @var bool
     */
    private $shopConsentAccepted;
    /**
     * @var int
     */
    private $shopId;
    /**
     * @var Context
     */
    private $context;
    /**
     * @var Db
     */
    private $db;

    public function __construct(
        Context $context,
        Db $db,
        ArrayFormatter $arrayFormatter,
        PsAccounts $psAccounts,
        ErrorHandlerInterface $errorHandler
    ) {
        $this->context = $context;
        $this->db = $db;
        $this->arrayFormatter = $arrayFormatter;
        $this->psAccountsService = $psAccounts->getPsAccountsService();
        $this->createdAt = $this->shopRepository->getCreatedAt();
        $this->errorHandler = $errorHandler;
    }

    public function getConsentByShopId($id)
    {
        $query = new DbQuery();

        $query->select('*')
            ->from('ps_merchant_consent')
            ->where('id_shop=' . $id);

        return $this->db->executeS($query);
    }

    /**
     * @param null $langIso
     *
     * @return array
     */
    public function getMerchantConsent($id)
    {

        $value = $this->getConsentByShopId($id);

        echo "<hr>";
        var_dump($value);
        exit(1);
        echo "</hr>";
        return [
            [
                'id' => '1',
                'collection' => Config::COLLECTION_SHOPS,
                'properties' => [
                    'created_at' => $this->createdAt,
                    'updated_at' => $this->updatedAt,
                    'module' => $this->module,
                    'shop_consent_revoked' => $this->shopConsentRevoked,
                    'shop_consent_accepted' => $this->shopConsentAccepted,
                    'id_shop' => $this->shopId,
                ],
            ],
        ];
    }

    private function getAccountsClient()
    {
        $module = \Module::getInstanceByName('ps_accounts');

        /* @phpstan-ignore-next-line */
        return $module->getService(AccountsClient::class);
    }
}
