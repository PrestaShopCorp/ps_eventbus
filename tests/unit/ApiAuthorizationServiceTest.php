<?php

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Api\EventBusSyncClient;
use PrestaShop\Module\PsEventbus\Repository\EventbusSyncRepository;
use PrestaShop\Module\PsEventbus\Service\ApiAuthorizationService;

class ApiAuthorizationServiceTest extends TestCase
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
     * @var EventBusSyncClient
     */
    private $eventBusSyncClient;

    public function setUp()
    {
        parent::setUp();

        $this->eventbusSyncRepository = $this->createMock(EventbusSyncRepository::class);
        $this->eventBusSyncClient = $this->createMock(EventBusSyncClient::class);
        $this->apiAuthorizationService = new ApiAuthorizationService(
            $this->eventbusSyncRepository,
            $this->eventBusSyncClient
        );
    }

    public function testAuthorizeCallSucceeds()
    {
        $jobId = '12345';

        $this->eventbusSyncRepository
            ->expects($this->at(0))
            ->method('findJobById')
            ->with($jobId)
            ->willReturn(['job_id' => '12345']);
        $this->eventBusSyncClient->expects($this->at(-1))->method('validateJobId')->willReturn(true);

        $this->assertTrue($this->apiAuthorizationService->authorizeCall($jobId));

        $this->eventbusSyncRepository
            ->expects($this->at(0))
            ->method('findJobById')
            ->with($jobId)
            ->willReturn(false);
        $this->eventBusSyncClient->expects($this->at(0))->method('validateJobId')->willReturn(['httpCode' => 201]);

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

        $this->eventBusSyncClient->method('validateJobId')->willReturn(['httpCode' => 201]);

        $this->assertFalse($this->apiAuthorizationService->authorizeCall($jobId));
    }
}
