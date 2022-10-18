<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\MerchantConsentRepository;

header('Access-Control-Allow-Origin: *'); // TODO set CDC origin

function getBearerToken($header)
{
    // HEADER: Get the access token from the header
    if (!empty($header)) {
        if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            return $matches[1];
        }
    }
    return null;
}
class ps_EventbusApiMerchantConsentModuleFrontController extends AbstractApiController
{
    public $type = Config::COLLECTION_SHOPS;
    public $auth = true;
    public $guestAllowed = false;
    /**
     * @throws PrestaShopException
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
        $this->checkJobId = false;
        $this->checkJWT = true;
    }
    public function postProcess()
    {
        try {


            if (!Tools::getIsset('module_consent')) {
                $this->exitWithResponse([
                    'error' => 'bad params'
                ]);
            }
            // TODO check if consents are valid
            $data = [
                'shop_id' => Context::getContext()->shop->id,
                'accepted' => json_encode(explode(',', Tools::getValue('accepted')), JSON_UNESCAPED_SLASHES),
                'revoked' => json_encode(explode(',', Tools::getValue('revoked')), JSON_UNESCAPED_SLASHES),
                'module_consent' => Tools::getValue('module_consent')
            ];

            /** @var MerchantConsentRepository $merchantConsentRepository */
            $merchantConsentRepository = $this->module->getService(MerchantConsentRepository::class);
            $merchantConsent = $merchantConsentRepository->postMerchantConsent($data);

            $this->exitWithResponse(
                array_merge(
                    [
                        'consentSaved' => true
                    ],
                    $merchantConsent
                )
            );
            // TODO call consent api
            // $response = $this->proxyService->upload($jobId, $merchantConsent, $this->startTime);
        } catch (EnvVarException $exception) {
            $this->exitWithExceptionMessage($exception);
        } catch (Exception $exception) {
            $this->exitWithExceptionMessage($exception);
        }
    }
}
