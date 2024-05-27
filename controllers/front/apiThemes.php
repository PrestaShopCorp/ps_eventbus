<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\ThemeRepository;

class ps_EventbusApiThemesModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_THEMES;

    /**
     * @return void
     *
     * @throws\PrestaShopException
     */
    public function postProcess()
    {
        $response = [];

        /** @var string $jobId */
        $jobId = Tools::getValue('job_id');

        /** @var ThemeRepository $themeRepository */
        $themeRepository = $this->module->getService(ThemeRepository::class);

        /** @var array $themeInfo */
        $themeInfo = $themeRepository->getThemes();

        /** @var bool $initFullSync */
        $initFullSync = \Tools::getValue('full', 0) == 1;

        try {
            $response = $this->proxyService->upload($jobId, $themeInfo, $this->startTime, $initFullSync);
        } catch (EnvVarException|Exception $exception) {
            $this->exitWithExceptionMessage($exception);
        }

        $this->exitWithResponse(
            array_merge(
                [
                  'remaining_objects' => 0,
                  'total_objects' => count($themeInfo),
                  'job_id' => $jobId,
                  'object_type' => $this->type,
                  'syncType' => 'full',
                ],
                $response
            )
        );
    }
}
