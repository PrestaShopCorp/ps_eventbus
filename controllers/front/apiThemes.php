<?php

use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\ThemeRepository;

class ps_EventbusApiThemesModuleFrontController extends AbstractApiController
{
    public $type = 'themes';

    /**
     * @return void
     */
    public function postProcess()
    {
        $response = [];

        $jobId = Tools::getValue('job_id');

        /** @var ThemeRepository $themeRepository */
        $themeRepository = $this->module->getService(ThemeRepository::class);

        $themeInfo = $themeRepository->getThemes();

        try {
            $response = $this->proxyService->upload($jobId, $themeInfo, $this->startTime);
        } catch (EnvVarException $exception) {
            $this->exitWithExceptionMessage($exception);
        } catch (Exception $exception) {
            $this->exitWithExceptionMessage($exception);
        }

        $this->exitWithResponse(
            array_merge(
                [
                    'remaining_objects' => 0,
                    'total_objects' => count($themeInfo),
                ],
                $response
            )
        );
    }
}
