<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Clients\RyanAirClient;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Airport;
use XMLHosting\TravelAgency\FlightData\Models\Trip;
use XMLHosting\TravelAgency\FlightData\Tests\BaseTest;

class TripFactoryTest extends BaseTest
{
    private static $trips;

    public static function setUpBeforeClass(): void
    {
        $body = self::getJSONMock('response-ryanair');
        $tripData = Helpers::getProperty(RyanAirClient::PROP_TRIPS, $body, []);

        self::$trips = Helpers::getInstances(TripFactory::class, $tripData);
    }

    /** @test */
    public function can_get_instances()
    {
        $expected = 1;
        $actual = self::$trips;
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = Trip::class;
        $actual = self::$trips[0];
        $this->assertInstanceOf($expected, $actual);

        $expected = Airport::class;
        $actual = self::$trips[0]->getOrigin();
        $this->assertInstanceOf($expected, $actual);

        $expected = Airport::class;
        $actual = self::$trips[0]->getDestination();
        $this->assertInstanceOf($expected, $actual);
    }
}
