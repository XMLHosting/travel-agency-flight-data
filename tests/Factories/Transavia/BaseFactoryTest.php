<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\Transavia;

use XMLHosting\TravelAgency\FlightData\Factories\Transavia\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Responses\GetTrips\TransaviaResponse as GetTripsResponse;
use XMLHosting\TravelAgency\FlightData\Tests\BaseTest;

abstract class BaseFactoryTest extends BaseTest
{
    protected static $trips = [];

    public static function setUpBeforeClass(): void
    {
        $body = self::getJSONMock('response-transavia');

        $tripData = Helpers::getProperty(GetTripsResponse::PROP_TRIPS, $body, []);
        self::$trips = Helpers::getInstances(TripFactory::class, $tripData);
    }
}
