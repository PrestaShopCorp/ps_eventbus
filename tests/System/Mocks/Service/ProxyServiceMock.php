<?php

namespace PrestaShop\Module\PsEventbus\Tests\System\Mocks\Service;

use PrestaShop\Module\PsEventbus\Service\ProxyServiceInterface;

class ProxyServiceMock implements ProxyServiceInterface
{
    public function upload($jobId, $data, $scriptStartTime)
    {
        return ['httpCode' => 201];
    }

    public function delete($jobId, $data)
    {
        return ['httpCode' => 201];
    }
}
