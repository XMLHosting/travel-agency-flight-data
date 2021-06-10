<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\Transavia;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Airport;

class AirportDestinationFactory extends BaseFactory
{
    const PROP_CODE = ['arrivalAirport', 'locationCode'];

    public function getInstance(array $data)
    {
        $code = Helpers::getProperty(self::PROP_CODE, $data, '');
        
        return Airport::build()->code($code);
    }
}
