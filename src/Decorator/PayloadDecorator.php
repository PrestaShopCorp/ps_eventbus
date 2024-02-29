<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Formatter\DateFormatter;

const DATE_FIELDS = [
  'created_at',
  'updated_at',
  'last_connection_date',
  'folder_created_at',
  'date_add',
];

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
            foreach (DATE_FIELDS as $dateField) {
                if (isset($payloadItem['properties'][$dateField])) {
                    $payloadItem['properties'][$dateField] =
                      $this->dateFormatter->convertToIso8061($payloadItem['properties']['created_at']);
                }
            }
        }
    }
}
