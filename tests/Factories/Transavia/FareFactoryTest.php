<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\Transavia;

use XMLHosting\TravelAgency\FlightData\Models\Fare;

class FareFactoryTest extends BaseFactoryTest
{
    private static $fares;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$fares = self::$trips[0]->getFlights()[0][0]->getPassengers()[0]->getFares();
    }

    /** @test */
    public function can_get_instances()
    {
        $expected = 1;
        $actual = self::$fares;
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = Fare::class;
        $actual = self::$fares[0];
        $this->assertInstanceOf($expected, $actual);

        $expected = 'economy';
        $actual = self::$fares[0]->getClass();
        $this->assertEquals($expected, $actual);

        $expected = 57.15;
        $actual = self::$fares[0]->getPrice();
        $this->assertEquals($expected, $actual);

        $expected = 'EUR';
        $actual = self::$fares[0]->getCurrency();
        $this->assertEquals($expected, $actual);
    }
}
