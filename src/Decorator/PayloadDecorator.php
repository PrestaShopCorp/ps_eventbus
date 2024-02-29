<?php

namespace PrestaShop\Module\PsEventbus\Decorator;

use PrestaShop\Module\PsEventbus\Repository\ConfigurationRepository;

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
     * @param array $payload
     *
     * @return void
     *
     * @throws \Exception
     */
    public function convertDateFormat(array &$payload)
    {
        foreach ($payload as &$payloadItem) {
            foreach (DATE_FIELDS as $dateField) {
                $date = &$payloadItem['properties'][$dateField];
                if (isset($date) && !empty($date) && $date !== '0000-00-00 00:00:00') {
                    $dateTime = new \DateTime($date, new \DateTimeZone($this->timezone));
                    $date = $dateTime->format(\DateTime::ISO8601);
                } else {
                    $date = null;
                }
            }
        }
    }
}
