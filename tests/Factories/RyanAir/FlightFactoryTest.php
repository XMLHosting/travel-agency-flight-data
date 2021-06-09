<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Clients\RyanAirClient;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Tests\BaseTest;

class FlightFactoryTest extends BaseTest
{
    private static $flights;

    public static function setUpBeforeClass(): void
    {
        $body = self::getJSONMock('response-ryanair');
        $tripData = Helpers::getProperty(RyanAirClient::PROP_TRIPS, $body, []);
        $trips = Helpers::getInstances(TripFactory::class, $tripData);

        self::$flights = $trips[0]->getFlights();
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

        $expected = 'FR';
        $actual = self::$flights[0][0]->getCarrier();
        $this->assertEquals($expected, $actual);

        $expected = 3102;
        $actual = self::$flights[0][0]->getNumber();
        $this->assertEquals($expected, $actual);

        $expected = 'AMS';
        $actual = self::$flights[0][0]->getOrigin()->getCode();
        $this->assertEquals($expected, $actual);

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
