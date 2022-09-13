<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\MerchantConsentRepository;

class ps_EventbusApiMerchantConsentModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SHOPS;

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $response = [];

        $shopId = Tools::getValue('shop_id');

        /** @var MerchantConsentRepository $merchantConsentRepository */
        $merchantConsentRepository = $this->module->getService(MerchantConsentRepository::class);

        $merchantConsent = $merchantConsentRepository->getMerchantConsent($shopId);

        echo "<hr>";
        var_dump($merchantConsent);
        exit(1);
        echo "</hr>";

        try {
//            $response = $this->proxyService->upload($jobId, $serverInfo, $this->startTime);
        } catch (EnvVarException $exception) {
            $this->exitWithExceptionMessage($exception);
        } catch (Exception $exception) {
            $this->exitWithExceptionMessage($exception);
        }

        $this->exitWithResponse(
            array_merge(
                [
                    'remaining_objects' => 0,
                    'total_objects' => 1,
                ],
                $response
            )
        );
    }
}
