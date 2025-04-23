<?php

namespace PrestaShop\Module\PsEventbus\Common;

class CommonServiceMock
{
    public static $lastResponse = [];

    public static function exitWithResponse(array $response): void
    {
        self::$lastResponse = $response;
    }
}
