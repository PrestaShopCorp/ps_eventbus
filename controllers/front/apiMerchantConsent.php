<?php

use PrestaShop\Module\PsEventbus\Config\Config;
use PrestaShop\Module\PsEventbus\Controller\AbstractApiController;
use PrestaShop\Module\PsEventbus\Exception\EnvVarException;
use PrestaShop\Module\PsEventbus\Repository\MerchantConsentRepository;

header('Access-Control-Allow-Origin: *'); // TODO set CDC origin

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

    /**
     * @return void
     */
    public function postProcess()
    {
        try {
            if (!Tools::getIsset('module_consent')) {
                $this->exitWithResponse([
                    'error' => 'bad params',
                ]);
            }
            // TODO check if consents types are valid
            // TODO check if module is install and active

            /** @var string $accepted */
            $accepted = Tools::getIsset('accepted') ? Tools::getValue('accepted') : '';
            /** @var string $revoked */
            $revoked = Tools::getIsset('revoked') ? Tools::getValue('revoked') : '';
            /** @var string $jwt */
            $jwt = Tools::getValue('jwt');
            /** @var string $moduleConsent */
            $moduleConsent = Tools::getValue('module_consent');
            /** @var int $shopId */
            $shopId = Context::getContext()->shop->id;

            $data = [
                'shop_id' => Context::getContext()->shop->id,
                'accepted' => json_encode(explode(',', $accepted), JSON_UNESCAPED_SLASHES),
                'revoked' => json_encode(explode(',', $revoked), JSON_UNESCAPED_SLASHES),
                'module_consent' => Tools::getValue('module_consent'),
            ];

            /** @var MerchantConsentRepository $merchantConsentRepository */
            $merchantConsentRepository = $this->module->getService(MerchantConsentRepository::class);
            $merchantConsent = $merchantConsentRepository->postMerchantConsent($data);

            $saved = $this->authorizationService->sendConsents($shopId, $jwt, $moduleConsent);

            $this->exitWithResponse(
                [
                    'consentSaved' => $saved,
                    'error' => $saved ? null : 'consent not saved to cloudsync',
                    'data' => $merchantConsent,
                ]
            );
        } catch (EnvVarException $exception) {
            $this->exitWithExceptionMessage($exception);
        } catch (Exception $exception) {
            $this->exitWithExceptionMessage($exception);
        }
    }
}
