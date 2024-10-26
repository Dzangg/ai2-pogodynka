<?php

namespace App\Tests\Entity;

use App\Entity\Forecast;
use PHPUnit\Framework\TestCase;

class ForecastTest extends TestCase
{
    public function dataGetFahrenheit(): array
    {
        return [
            ['0', 32],
            ['-100', -148],
            ['100', 212],
            ['0.5', 32.9],
            ['10', 50],
            ['20', 68],
            ['-40', -40],
            ['37', 98.6],
            ['15.5', 59.9],
            ['-10.5', 13.1],
        ];
    }
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $forecast = new Forecast();
        $forecast->setCelsius($celsius);
        $this->assertEquals($expectedFahrenheit, $forecast->getFahrenheit(), "{$celsius}°C should be {$expectedFahrenheit}°F");
    }
}
