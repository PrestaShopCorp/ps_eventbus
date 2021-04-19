<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\ApiException;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\ServerInformationRepository;
use PrestaShop\Module\PsEventbus\Repository\TaxRepository;

class ps_EventbusApiTaxModuleFrontController extends AbstractApiController
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

        /** @var TaxRepository $taxRepository */
        $taxRepository = $this->module->getService(TaxRepository::class);

        // we get all taxes here but there are lot of different group rules so what group should we use?
        $taxes = $taxRepository->getTaxes($context->language->id);

        try {
            $response = $this->proxyService->upload($jobId, $taxes, $this->startTime);
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
