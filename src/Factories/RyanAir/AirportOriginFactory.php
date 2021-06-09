<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Airport;

class AirportOriginFactory extends BaseFactory
{
    const PROP_CODE = 'origin';
    const PROP_NAME = 'originName';

    public function getInstance(array $data)
    {
        $code = Helpers::getProperty(self::PROP_CODE, $data, '');
        $name = Helpers::getProperty(self::PROP_NAME, $data, '');
        
        return Airport::build()->code($code)->name($name);
    }
}
