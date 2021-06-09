<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Clients\RyanAirClient;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Tests\BaseTest;

class PassengerFactoryTest extends BaseTest
{
    private static $passengers;

    public static function setUpBeforeClass(): void
    {
        $body = self::getJSONMock('response-ryanair');
        $tripData = Helpers::getProperty(RyanAirClient::PROP_TRIPS, $body, []);
        $trips = Helpers::getInstances(TripFactory::class, $tripData);

        self::$passengers = $trips[0]->getFlights()[0][0]->getPassengers();
    }

    /** @test */
    public function can_get_instances()
    {
        $expected = 1;
        $actual = self::$passengers;
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = 'adult';
        $actual = self::$passengers[0]->getAgeGroup();
        $this->assertEquals($expected, $actual);

        $expected = 1;
        $actual = self::$passengers[0]->getAmount();
        $this->assertEquals($expected, $actual);
    }
}
