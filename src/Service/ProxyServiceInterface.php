<?php

namespace PrestaShop\Module\PsEventbus\Service;

interface ProxyServiceInterface
{
    /**
     * @param string $jobId
     * @param array $data
     * @param int $scriptStartTime
     * @param bool $isFull
     *
     * @return array
     */
    public function upload($jobId, $data, $scriptStartTime, bool $isFull = false);

    /**
     * @param string $jobId
     * @param array $data
     * @param int $scriptStartTime
     *
     * @return array
     */
    public function delete($jobId, $data, $scriptStartTime);
}
