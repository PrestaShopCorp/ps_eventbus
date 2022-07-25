<?php

namespace PrestaShop\Module\PsEventbus\Service;

interface ProxyServiceInterface
{
    public function upload($jobId, $data, $scriptStartTime, bool $isFull = false);

    public function delete($jobId, $data);
}
