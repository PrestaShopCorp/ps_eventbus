<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\ApiException;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\CarrierRepository;
use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;

class ps_EventbusApiShippingModuleFrontController extends AbstractApiController
{
    public $type = 'shops';

    /**
     * @throws PrestaShopException
     *
     * @return void
     */
    public function postProcess()
    {
        $response = [];

        $context = Context::getContext();
        $jobId = Tools::getValue('job_id');

        /** @var CarrierRepository $carrierRepository */
        $carrierRepository = $this->module->getService(CarrierRepository::class);

        $carriers = $carrierRepository->getCarriers($context->language->id);
        $countries = Country::getCountries($context->language->id, true);
        // todo: need to get selected countries from google module

        try {
            $response = $this->proxyService->upload($jobId, $carriers, $this->startTime);
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
