<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;

// use hardcoded format to avoid problems with interface change in PHP 7.2
const ISO8601 = 'Y-m-d\TH:i:sO';
const DATE_FIELDS = [
    'created_at',
    'updated_at',
    'last_connection_date',
    'folder_created_at',
    'date_add',
    'newsletter_date_add',
    'from',
    'to',
];

class PayloadDecorator
{
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;
    /**
     * @var string
     */
    private $timezone;

    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
        $this->timezone = (string) $this->configurationRepository->get('PS_TIMEZONE');
    }

    /**
     * @param array<mixed> $payload
     *
     * @return void
     *
     * @throws \Exception
     */
    public function convertDateFormat(&$payload)
    {
        foreach ($payload as &$payloadItem) {
            foreach (DATE_FIELDS as $dateField) {
                if (isset($payloadItem['properties'][$dateField])) {
                    $date = &$payloadItem['properties'][$dateField];
                    if (!empty($date) && $date !== '0000-00-00 00:00:00') {
                        $dateTime = new \DateTime($date, new \DateTimeZone($this->timezone));
                        $date = $dateTime->format(ISO8601);
                    } else {
                        $date = null;
                    }
                }
            }
        }
    }
}
