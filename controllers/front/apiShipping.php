<?php

use PrestaShop\Module\PsEventbus\Builder\CarrierBuilder;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\DTO\Carrier as EventBusCarrier;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;

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

        $language = new Language(Configuration::get('PS_LANG_DEFAULT'));
        $currency = new Currency(Configuration::get('PS_CURRENCY_DEFAULT'));

        $jobId = Tools::getValue('job_id');

        /** @var CarrierBuilder $carrierBuilder */
        $carrierBuilder = $this->module->getService(CarrierBuilder::class);

        $carriers = Carrier::getCarriers($language->id);

        /** @var EventBusCarrier[] $eventBusCarriers */
        $eventBusCarriers = $carrierBuilder->buildCarriers(
            $carriers,
            $language,
            $currency,
            Configuration::get('PS_WEIGHT_UNIT')
        );

        try {
            $response = $this->proxyService->upload($jobId, $eventBusCarriers, $this->startTime);
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
