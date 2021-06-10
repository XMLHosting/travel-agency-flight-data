<?php
namespace XMLHosting\TravelAgency\FlightData\Responses\Transavia;

use XMLHosting\TravelAgency\FlightData\Factories\Transavia\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Responses\BaseResponse;

class GetTripsResponse extends BaseResponse
{
    const PROP_TRIPS = 'flightOffer';

    public function body($value): self
    {
        $trips = [];

        if ($this->getStatusCode() === 200) {
            $value = json_decode($value, true);

            $tripData = Helpers::getProperty(self::PROP_TRIPS, $value, []);
            $trips = Helpers::getInstances(TripFactory::class, $tripData);
        }

        return parent::body($trips);
    }
}
