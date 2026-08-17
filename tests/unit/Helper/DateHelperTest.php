<?php

namespace PrestaShop\Module\PsEventbus\Tests\Helper;

use PHPUnit\Framework\TestCase;
use PrestaShop\Module\PsEventbus\Helper\DateHelper;

class DateHelperTest extends TestCase
{
    public function testConvertsIso8601ToMysqlDateTime()
    {
        $this->assertSame(
            '2026-08-13 11:26:59',
            DateHelper::toMySqlDateTime('2026-08-13T11:26:59+02:00')
        );
    }

    public function testKeepsTheWallClockOfTheProvidedOffset()
    {
        $this->assertSame(
            '2026-08-13 11:26:59',
            DateHelper::toMySqlDateTime('2026-08-13T11:26:59-07:00')
        );
    }

    public function testLeavesAnAlreadyValidMysqlDateTimeUntouched()
    {
        $this->assertSame(
            '2026-08-13 11:26:59',
            DateHelper::toMySqlDateTime('2026-08-13 11:26:59')
        );
    }

    public function testCompletesADateWithoutTime()
    {
        $this->assertSame(
            '2026-08-13 00:00:00',
            DateHelper::toMySqlDateTime('2026-08-13')
        );
    }

    /**
     * @dataProvider provideUnusableDates
     *
     * @param mixed $date
     *
     * @return void
     */
    public function testFallsBackToNowOnUnusableDates($date)
    {
        $before = date('Y-m-d H:i:s', time() - 1);
        $normalized = DateHelper::toMySqlDateTime($date);
        $after = date('Y-m-d H:i:s', time() + 1);

        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/',
            $normalized
        );
        $this->assertGreaterThanOrEqual($before, $normalized);
        $this->assertLessThanOrEqual($after, $normalized);
    }

    /**
     * @return array<string, array<mixed>>
     */
    public static function provideUnusableDates()
    {
        return [
            'null' => [null],
            'empty string' => [''],
            'zero date' => ['0000-00-00 00:00:00'],
            'garbage' => ['not-a-date'],
        ];
    }
}
