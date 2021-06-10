<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\Transavia;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Factories\Transavia\FareFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Passenger;

class PassengerFactory extends BaseFactory
{
    const PROP_TOTAL = 'totalPriceAllPassengers';
    const PROP_SUB_TOTAL = 'totalPriceOnePassenger';

    public function getInstance(array $data)
    {
        $total = Helpers::getProperty(self::PROP_TOTAL, $data, 0);
        $subTotal = Helpers::getProperty(self::PROP_SUB_TOTAL, $data, 0);
        $amount = round($total / $subTotal);

        $fares = Helpers::getInstances(FareFactory::class, [$data]);

        return Passenger::build()
            ->amount($amount)
            ->fares($fares);
    }
}
