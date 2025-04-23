<?php

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Common\CommonServiceMock;
use PrestaShop\Module\PsEventbus\Service\ApiShopContentService;
use PrestaShop\Module\PsEventbus\Service\ApiAuthorizationService;
use PrestaShop\Module\PsEventbus\Service\SynchronizationService;
use PrestaShop\Module\PsEventbus\Repository\SyncRepository;
use PrestaShop\Module\PsEventbus\Handler\ErrorHandler\ErrorHandler;
use PrestaShop\Module\PsEventbus\Service\ShopContent\LanguagesService;

class ApiShopContentServiceTest extends TestCase
{
    public function testHandleDataSyncTriggersFullSyncWhenTypeSyncIsMissing()
    {

        $apiAuthMock = $this->getMockBuilder(SyncRepository::class)
            ->setConstructorArgs([]);
        var_dump('test');
        /** @var \Ps_eventbus&PHPUnit\Framework\MockObject\MockObject $moduleMock */
        $moduleMock = $this->createMock(\Ps_eventbus::class);

        /* /** @var ApiAuthorizationService&PHPUnit\Framework\MockObject\MockObject $apiAuthMock */
        /* $apiAuthMock = $this->createMock(ApiAuthorizationService::class); */

        /** @var SynchronizationService&PHPUnit\Framework\MockObject\MockObject $syncServiceMock */
        /* $syncServiceMock = $this->createMock(SynchronizationService::class); */

        /** @var SyncRepository&PHPUnit\Framework\MockObject\MockObject $syncRepoMock */
        /* $syncRepoMock = $this->createMock(SyncRepository::class); */

        /** @var ErrorHandler&PHPUnit\Framework\MockObject\MockObject $errorHandlerMock */
        /* $errorHandlerMock = $this->createMock(ErrorHandler::class); */

        /** @var LanguagesService&PHPUnit\Framework\MockObject\MockObject $languagesServiceMock */
        /* $languagesServiceMock = $this->createMock(LanguagesService::class); */

        // Expectations
        /*         $apiAuthMock->expects($this->once())->method('authorize');

        $syncRepoMock->expects($this->once())
            ->method('findTypeSync')
            ->willReturn(null); // typeSync inexistant

        $syncRepoMock->expects($this->once())
            ->method('upsertTypeSync');

        $languagesServiceMock->method('getDefaultLanguageIsoCode')
            ->willReturn('en');

        $syncServiceMock->expects($this->once())
            ->method('sendFullSync')
            ->willReturn(['result' => 'ok']);

        $moduleMock->method('getService')
            ->willReturnMap([
                [LanguagesService::class, $languagesServiceMock],
            ]);

        // On mocke la config globalement
        \Configuration::set('PS_TIMEZONE', 'UTC');

        // On mocke la méthode exitWithResponse pour intercepter sa sortie
        require_once __DIR__ . '/MockedCommonService.php';

        $service = new ApiShopContentService(
            $moduleMock,
            $apiAuthMock,
            $syncServiceMock,
            $syncRepoMock,
            $errorHandlerMock
        );

        // Appel réel
        $response = $service->handleDataSync('product', 'job123', '', 100, true);

        // Comme exitWithResponse est redéfini, on peut vérifier ce qui aurait été renvoyé
        $this->assertSame(CommonServiceMock::$lastResponse['syncType'], 'full');
        $this->assertSame(CommonServiceMock::$lastResponse['job_id'], 'job123'); */
    }
}
