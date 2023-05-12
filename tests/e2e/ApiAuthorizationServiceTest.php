<?php

use PrestaShop\Module\PsEventbus\Api\SyncApiClient;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Service\ApiAuthorizationService;
use PrestaShop\Module\PsEventbus\Tests\System\Tests\BaseTestCase;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;

/**
 * @Features("authorization")
 * @Stories("api authorization service")
 */
class ApiAuthorizationServiceTest extends BaseTestCase
{
    /**
     * @var EventbusSyncRepository
     */
    private $eventbusSyncRepository;
    /**
     * @var ApiAuthorizationService
     */
    private $apiAuthorizationService;
    /**
     * @var SyncApiClient
     */
    private $syncApiClient;

    public function setUp(): void
    {
        parent::setUp();

        $this->eventbusSyncRepository = $this->createMock(EventbusSyncRepository::class);
        $this->syncApiClient = $this->createMock(SyncApiClient::class);
        $this->apiAuthorizationService = new ApiAuthorizationService(
            $this->eventbusSyncRepository,
            $this->syncApiClient
        );
    }

    /**
     * @Stories("api authorization service")
     * @Title("testAuthorizeCallSucceeds")
     */
    public function testAuthorizeCallSucceeds()
    {
        $jobId = '12345';

        $this->eventbusSyncRepository
            ->expects($this->at(0))
            ->method('findJobById')
            ->with($jobId)
            ->willReturn(['job_id' => '12345']);
        $this->syncApiClient->expects($this->at(-1))->method('validateJobId')->willReturn(true);

        $this->assertTrue($this->apiAuthorizationService->authorizeCall($jobId));

        $this->eventbusSyncRepository
            ->expects($this->at(0))
            ->method('findJobById')
            ->with($jobId)
            ->willReturn(false);
        $this->syncApiClient->expects($this->at(0))->method('validateJobId')->willReturn(['httpCode' => 201]);

        $this->eventbusSyncRepository
            ->expects($this->atLeastOnce())
            ->method('insertJob')
            ->willReturn(true);

        $this->assertTrue($this->apiAuthorizationService->authorizeCall($jobId));
    }

    public function testAuthorizeCallFails()
    {
        $jobId = '12345';

        $this->eventbusSyncRepository
            ->expects($this->at(0))
            ->method('findJobById')
            ->with($jobId)
            ->willReturn(false);

        $this->eventbusSyncRepository
            ->expects($this->atLeastOnce())
            ->method('insertJob')
            ->willReturn(false);

        $this->syncApiClient->method('validateJobId')->willReturn(['httpCode' => 201]);

        $this->assertFalse($this->apiAuthorizationService->authorizeCall($jobId));
    }
}
