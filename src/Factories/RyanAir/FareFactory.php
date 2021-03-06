<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Fare;

class FareFactory extends BaseFactory
{
    const PROP_CLASS = 'fareClass';
    const PROP_PRICE = 'amount';

    public function getInstance(array $data)
    {
        $class = Helpers::getProperty(self::PROP_CLASS, $data);
        $price = Helpers::getProperty(self::PROP_PRICE, $data);
        
        return Fare::build()
            ->class($class)
            ->price($price);
    }
}
