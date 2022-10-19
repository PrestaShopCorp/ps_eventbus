<?php

namespace PrestaShop\Module\PsEventbus\Service;

use PrestaShop\Module\PsAccounts\Service\PsAccountsService;
use PrestaShop\Module\PsEventbus\Api\EventBusSyncClient;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Repository\MerchantConsentRepository;
use PrestaShopDatabaseException;

class ApiAuthorizationService
{
    /**
     * @var EventbusSyncRepository
     */
    private $eventbusSyncStateRepository;
    /**
     * @var EventBusSyncClient
     */
    private $eventBusSyncClient;
    /**
     * @var MerchantConsentRepository
     */
    private $merchantConsentRepository;

    public function __construct(
        EventbusSyncRepository $eventbusSyncStateRepository,
        EventBusSyncClient $eventBusSyncClient,
        MerchantConsentRepository $merchantConsentRepository,
    ) {
        $this->eventbusSyncStateRepository = $eventbusSyncStateRepository;
        $this->eventBusSyncClient = $eventBusSyncClient;
        $this->merchantConsentRepository = $merchantConsentRepository;
    }

    /**
     * Authorizes if the call to endpoint is legit and creates sync state if needed
     *
     * @param string $jobId
     *
     * @return array|bool
     *
     * @throws PrestaShopDatabaseException|EnvVarException
     */
    public function authorizeCall($jobId)
    {
        $job = $this->eventbusSyncStateRepository->findJobById($jobId);

        if ($job) {
            return true;
        }

        $jobValidationResponse = $this->eventBusSyncClient->validateJobId($jobId);

        if (is_array($jobValidationResponse) && (int) $jobValidationResponse['httpCode'] === 201) {
            return $this->eventbusSyncStateRepository->insertJob($jobId, date(DATE_ATOM));
        }

        return $jobValidationResponse;
    }

    /**
     * Send the consents to cloudsync
     *
     * @param string $shopId
     *
     * @return bool
     *
     * @throws PrestaShopDatabaseException|EnvVarException
     */
    public function sendConsents($shopId, $accountJWT, $moduleName)
    {
        $consents = $this->merchantConsentRepository->getMerchantConsent($moduleName, $shopId);

        $accountsModule = \Module::getInstanceByName('ps_accounts');
        $accountService = $accountsModule->getService(PsAccountsService::class);
        $shopUuid = $accountService->getShopUuid();

        $consentResponse = $this->eventBusSyncClient->validateConsent($shopUuid, $accountJWT, $moduleName, $consents['shop-consent-accepted'], $consents['shop-consent-revoked']);

        return (int) $consentResponse['httpCode'] === 201;
    }
}
