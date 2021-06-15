<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\Transavia;

use \DateTime;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Flight;
use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Factories\Transavia\PassengerFactory;
use XMLHosting\TravelAgency\FlightData\Factories\Transavia\AirportOriginFactory;
use XMLHosting\TravelAgency\FlightData\Factories\Transavia\AirportDestinationFactory;

class FlightFactory extends BaseFactory
{
    const PROP_CARRIER = ['marketingAirline', 'companyShortName'];
    const PROP_NUMBER = 'flightNumber';
    const PROP_DEPARTS_AT_UTC = 'departureDateTime';
    const PROP_ARRIVES_AT_UTC = 'arrivalDateTime';
    const PROP_PASSENGERS = 'pricingInfo';

    public function getInstance(array $data)
    {
        $carrier = Helpers::getProperty(self::PROP_CARRIER, $data);
        $number = Helpers::getProperty(self::PROP_NUMBER, $data);

        $origin = Helpers::getInstance(AirportOriginFactory::class, $data);
        $destination = Helpers::getInstance(AirportDestinationFactory::class, $data);

        $departsAtUTC = new DateTime(Helpers::getProperty(self::PROP_DEPARTS_AT_UTC, $data));
        $arrivesAtUTC = new DateTime(Helpers::getProperty(self::PROP_ARRIVES_AT_UTC, $data));

        $passengerData = Helpers::getProperty(self::PROP_PASSENGERS, $data, []);
        $passengers = Helpers::getInstances(PassengerFactory::class, [$passengerData]);

        return Flight::build()
            ->carrier($carrier)
            ->number($number)
            ->origin($origin)
            ->destination($destination)
            ->departsAtUTC($departsAtUTC)
            ->arrivesAtUTC($arrivesAtUTC)
            ->passengers($passengers);
    }

    public function getInstances(array $data): array
    {
        return array_map(function ($flights) {
            return array_map(function ($flight) {
                return $this->getInstance($flight);
            }, $flights);
        }, $data);
    }
}
