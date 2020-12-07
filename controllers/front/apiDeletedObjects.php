<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Service\DeletedObjectsService;

class ps_EventbusApiDeletedObjectsModuleFrontController extends AbstractApiController
{
    public $type = 'deleted';

    /**
     * @return void
     */
    public function postProcess()
    {
        $jobId = Tools::getValue('job_id', '');

        /** @var DeletedObjectsService $deletedObjectsService */
        $deletedObjectsService = $this->module->getService(DeletedObjectsService::class);

        try {
            $response = $deletedObjectsService->handleDeletedObjectsSync($jobId);
            $this->exitWithResponse($response);
        } catch (PrestaShopDatabaseException $exception) {
            $this->exitWithExceptionMessage($exception);
        } catch (EnvVarException $exception) {
            $this->exitWithExceptionMessage($exception);
        }
    }
}
