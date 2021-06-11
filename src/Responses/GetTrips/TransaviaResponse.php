<?php
namespace XMLHosting\TravelAgency\FlightData\Responses\GetTrips;

use XMLHosting\TravelAgency\FlightData\Factories\Transavia\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Responses\BaseResponse;

class TransaviaResponse extends BaseResponse
{
    const PROP_TRIPS = 'flightOffer';

    public function parseBody($value)
    {
        $value = json_decode($value, true);

        $tripData = Helpers::getProperty(self::PROP_TRIPS, $value, []);
        return Helpers::getInstances(TripFactory::class, $tripData);
    }
}
