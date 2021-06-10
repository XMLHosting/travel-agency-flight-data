<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\Transavia;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Fare;

class FareFactory extends BaseFactory
{
    const PROP_PRICE = 'totalPriceOnePassenger';
    const PROP_CURRENCY = 'currencyCode';

    public function getInstance(array $data)
    {
        $price = Helpers::getProperty(self::PROP_PRICE, $data);
        $currency = Helpers::getProperty(self::PROP_CURRENCY, $data);

        return Fare::build()
            ->price($price)
            ->currency($currency);
    }
}
