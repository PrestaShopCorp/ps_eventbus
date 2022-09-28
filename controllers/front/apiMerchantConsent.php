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

        $data = [
            'shop_id' => Context::getContext()->shop->id,
            'accepted' => Tools::getValue('accepted'),
            'revoked' => Tools::getValue('revoked'),
            'module_consent' => Tools::getValue('module_consent'),
        ];

        try {
            /** @var MerchantConsentRepository $merchantConsentRepository */
            $merchantConsentRepository = $this->module->getService(MerchantConsentRepository::class);
            $merchantConsent = $merchantConsentRepository->postMerchantConsent($data);
            $response = $this->proxyService->upload(Tools::getValue('job_id'), $merchantConsent, $this->startTime);
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
