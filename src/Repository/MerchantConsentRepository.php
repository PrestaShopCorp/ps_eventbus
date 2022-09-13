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

        return [
            [
                'id' => $value['id'],
                'collection' => Config::COLLECTION_MERCHANT_CONSENT,
                'properties' => [
                    'created_at' => $value['createdAt'],
                    'updated_at' => $value['updatedAt'],
                    'module' => $value['module'],
                    'shop_consent_revoked' => $value['shopConsentRevoked'],
                    'shop_consent_accepted' => $value['shopConsentAccepted'],
                    'id_shop' => $value['shopId'],
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
