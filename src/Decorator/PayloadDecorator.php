<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Formatter\DateFormatter;

class PayloadDecorator
{
    /**
     * @var DateFormatter
     */
    private $dateFormatter;

    public function __construct(DateFormatter $dateFormatter)
    {
        $this->dateFormatter = $dateFormatter;
    }

    /**
     * @param array $payload
     *
     * @return void
     */
    public function convertDateFormat(array &$payload)
    {
        foreach ($payload as &$payloadItem) {
            if (isset($payloadItem['properties']['created_at'])) {
                $payloadItem['properties']['created_at'] =
                    $this->dateFormatter->convertToIso8061($payloadItem['properties']['created_at']);
            }

            if (isset($payloadItem['properties']['updated_at'])) {
                $payloadItem['properties']['updated_at'] =
                    $this->dateFormatter->convertToIso8061($payloadItem['properties']['updated_at']);
            }

            if (isset($payloadItem['properties']['from'])) {
                $payloadItem['properties']['from'] =
                    $this->dateFormatter->convertToIso8061($payloadItem['properties']['from']);
            }

            if (isset($payloadItem['properties']['to'])) {
                $payloadItem['properties']['to'] =
                    $this->dateFormatter->convertToIso8061($payloadItem['properties']['to']);
            }
        }
    }
}
