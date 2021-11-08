<?php

namespace PrestaShop\Module\PsEventbus\Service;

interface ProxyServiceInterface
{
    public function upload($jobId, $data, $scriptStartTime);

    public function delete($jobId, $data);
}
