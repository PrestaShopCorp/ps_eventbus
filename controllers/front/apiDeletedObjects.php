<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Service\DeletedObjectsService;

class ps_EventbusApiDeletedObjectsModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_DELETED;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        /** @var string $jobId */
        $jobId = Tools::getValue('job_id', '');

        /** @var DeletedObjectsService $deletedObjectsService */
        $deletedObjectsService = $this->module->getService(DeletedObjectsService::class);

        try {
            $response = $deletedObjectsService->handleDeletedObjectsSync($jobId, $this->startTime);
            $this->exitWithResponse($response);
        } catch (PrestaShopDatabaseException $exception) {
            $this->exitWithExceptionMessage($exception);
        } catch (EnvVarException $exception) {
            $this->exitWithExceptionMessage($exception);
        }
    }
}
