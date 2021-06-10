<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Hooks;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Fare;
use XMLHosting\TravelAgency\FlightData\Tests\BaseTest;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\TripFactory;
use XMLHosting\TravelAgency\FlightData\Responses\RyanAir\GetTripsResponse;

abstract class BaseFactoryTest extends BaseTest
{
    protected static $trips = [];

    public static function setUpBeforeClass(): void
    {
        $body = self::getJSONMock('response-ryanair');

        Hooks::add(Fare::HOOK_GET_BASE_CURRENCY, function () use ($body) {
            return Helpers::getProperty(GetTripsResponse::PROP_CURRENCY, $body);
        });

        $tripData = Helpers::getProperty(GetTripsResponse::PROP_TRIPS, $body, []);
        self::$trips = Helpers::getInstances(TripFactory::class, $tripData);
    }
}