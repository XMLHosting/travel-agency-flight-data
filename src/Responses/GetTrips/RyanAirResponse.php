<?php
namespace XMLHosting\TravelAgency\FlightData\Responses\GetTrips;

use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Hooks;
use XMLHosting\TravelAgency\FlightData\Models\Fare;
use XMLHosting\TravelAgency\FlightData\Responses\BaseResponse;

class RyanAirResponse extends BaseResponse
{
    const PROP_TRIPS = 'trips';
    const PROP_CURRENCY = 'currency';

    public function parseBody($value)
    {
        $value = json_decode($value, true);

        Hooks::add(Fare::HOOK_GET_BASE_CURRENCY, function () use ($value) {
            return Helpers::getProperty(self::PROP_CURRENCY, $value);
        });

        $tripData = Helpers::getProperty(self::PROP_TRIPS, $value, []);
        return Helpers::getInstances(TripFactory::class, $tripData);
    }
}
