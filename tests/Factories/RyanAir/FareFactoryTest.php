<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Clients\RyanAirClient;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Hooks;
use XMLHosting\TravelAgency\FlightData\Models\Fare;
use XMLHosting\TravelAgency\FlightData\Tests\BaseTest;

class FareFactoryTest extends BaseTest
{
    private static $fares;

    public static function setUpBeforeClass(): void
    {
        $body = self::getJSONMock('response-ryanair');

        Hooks::add(Fare::HOOK_GET_BASE_CURRENCY, function () use ($body) {
            return Helpers::getProperty(RyanAirClient::PROP_CURRENCY, $body);
        });

        $tripData = Helpers::getProperty(RyanAirClient::PROP_TRIPS, $body, []);
        $trips = Helpers::getInstances(TripFactory::class, $tripData);

        self::$fares = $trips[0]->getFlights()[0][0]->getPassengers()[0]->getFares();
    }

    /** @test */
    public function can_get_instances()
    {
        $expected = 1;
        $actual = self::$fares;
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = 30.99;
        $actual = self::$fares[0]->getPrice();
        $this->assertEquals($expected, $actual);

        $expected = 'EUR';
        $actual = self::$fares[0]->getCurrency();
        $this->assertEquals($expected, $actual);
    }
}
