<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Models\Flight;
use XMLHosting\TravelAgency\FlightData\Models\Airport;

class FlightFactoryTest extends BaseFactoryTest
{
    private static $flights;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$flights = self::$trips[0]->getFlights();
    }

    /** @test */
    public function can_get_instances()
    {
        $expected = 1;
        $actual = self::$flights;
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = 2;
        $actual = self::$flights[0];
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = Flight::class;
        $actual = self::$flights[0][0];
        $this->assertInstanceOf($expected, $actual);

        $expected = 'FR';
        $actual = self::$flights[0][0]->getCarrier();
        $this->assertEquals($expected, $actual);

        $expected = 3102;
        $actual = self::$flights[0][0]->getNumber();
        $this->assertEquals($expected, $actual);

        $expected = Airport::class;
        $actual = self::$flights[0][0]->getOrigin();
        $this->assertInstanceOf($expected, $actual);

        $expected = 'AMS';
        $actual = self::$flights[0][0]->getOrigin()->getCode();
        $this->assertEquals($expected, $actual);

        $expected = Airport::class;
        $actual = self::$flights[0][0]->getDestination();
        $this->assertInstanceOf($expected, $actual);

        $expected = 'ABC';
        $actual = self::$flights[0][0]->getDestination()->getCode();
        $this->assertEquals($expected, $actual);

        $expected = 'FR';
        $actual = self::$flights[0][1]->getCarrier();
        $this->assertEquals($expected, $actual);

        $expected = 3103;
        $actual = self::$flights[0][1]->getNumber();
        $this->assertEquals($expected, $actual);

        $expected = 'ABC';
        $actual = self::$flights[0][1]->getOrigin()->getCode();
        $this->assertEquals($expected, $actual);

        $expected = 'DUB';
        $actual = self::$flights[0][1]->getDestination()->getCode();
        $this->assertEquals($expected, $actual);
    }
}
