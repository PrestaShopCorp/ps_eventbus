<?php

namespace PrestaShop\Module\PsEventbus\Interfaces;

interface ProxyServiceInterface
{
    /**
     * @param string $jobId
     * @param array<mixed> $data
     * @param int $scriptStartTime
     * @param bool $isFull
     *
     * @return array<mixed>
     */
    public function upload($jobId, $data, $scriptStartTime, $isFull);

    /**
     * @param string $jobId
     * @param array<mixed> $data
     * @param int $scriptStartTime
     *
     * @return array<mixed>
     */
    public function delete($jobId, $data, $scriptStartTime);
}
