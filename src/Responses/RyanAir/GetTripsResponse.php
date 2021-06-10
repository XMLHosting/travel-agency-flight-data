<?php
namespace XMLHosting\TravelAgency\FlightData\Responses\RyanAir;

use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\TripFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Hooks;
use XMLHosting\TravelAgency\FlightData\Models\Fare;
use XMLHosting\TravelAgency\FlightData\Responses\BaseResponse;

class GetTripsResponse extends BaseResponse
{
    const PROP_TRIPS = 'trips';
    const PROP_CURRENCY = 'currency';

    public function body($value): self
    {
        $trips = [];

        if ($this->getStatusCode() === 200) {
            $value = json_decode($value, true);

            Hooks::add(Fare::HOOK_GET_BASE_CURRENCY, function () use ($value) {
                return Helpers::getProperty(self::PROP_CURRENCY, $value);
            });

            $tripData = Helpers::getProperty(self::PROP_TRIPS, $value, []);
            $trips = TripFactory::getInstances($tripData);
        }

        return parent::body($trips);
    }
}
