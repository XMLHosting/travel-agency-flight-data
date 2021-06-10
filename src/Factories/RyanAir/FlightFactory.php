<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\RyanAir;

use \DateTime;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Flight;
use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\PassengerFactory;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\AirportOriginFactory;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\AirportDestinationFactory;

class FlightFactory extends BaseFactory
{
    const PROP_SEGMENTS = 'segments';
    const PROP_ORDER = 'segmentNr';
    const PROP_CODE = 'flightNumber';
    const PROP_DEPARTS_AT_UTC = ['timeUTC', 0];
    const PROP_DEPARTS_AT_LOCAL = ['time', 0];
    const PROP_ARRIVES_AT_UTC = ['timeUTC', 1];
    const PROP_ARRIVES_AT_LOCAL = ['time', 1];
    const PROP_BASE_PASSENGER = 'regularFare';
    const PROP_PASSENGERS = ['regularFare', 'fares'];

    public function getInstance(array $data)
    {
        $order = Helpers::getProperty(self::PROP_ORDER, $data);

        $code = Helpers::getProperty(self::PROP_CODE, $data);
        $carrier = preg_replace('/[0-9\s]+/', '', $code);
        $number = preg_replace('/[a-z\s]+/i', '', $code);

        $origin = Helpers::getInstance(AirportOriginFactory::class, $data);
        $destination = Helpers::getInstance(AirportDestinationFactory::class, $data);

        $departsAtUTC = new DateTime(Helpers::getProperty(self::PROP_DEPARTS_AT_UTC, $data));
        $departsAtLocal = new DateTime(Helpers::getProperty(self::PROP_DEPARTS_AT_LOCAL, $data));
        $arrivesAtUTC = new DateTime(Helpers::getProperty(self::PROP_ARRIVES_AT_UTC, $data));
        $arrivesAtLocal = new DateTime(Helpers::getProperty(self::PROP_ARRIVES_AT_LOCAL, $data));

        $passengerData = array_map(function($passenger) use ($data) {
            $basePassenger = Helpers::getProperty(self::PROP_BASE_PASSENGER, $data, []);
            $basePassenger = array_filter($basePassenger, 'is_scalar');
            return array_merge($basePassenger, $passenger);
        }, Helpers::getProperty(self::PROP_PASSENGERS, $data, []));

        $passengers = Helpers::getInstances(PassengerFactory::class, $passengerData);

        return Flight::build()
            ->order($order)
            ->carrier($carrier)
            ->number($number)
            ->origin($origin)
            ->destination($destination)
            ->departsAtUTC($departsAtUTC)
            ->departsAtLocal($departsAtLocal)
            ->arrivesAtUTC($arrivesAtUTC)
            ->arrivesAtLocal($arrivesAtLocal)
            ->passengers($passengers);
    }

    public function getInstances(array $data): array
    {
        return array_map(function ($flight) {
            $segments = Helpers::getProperty(self::PROP_SEGMENTS, $flight, []);

            $flights = array_map(function ($item) use ($flight) {
                return $this->getInstance(array_merge($flight, $item));
            }, $segments);

            usort($flights, function ($a, $b) {
                return $a->getOrder() - $b->getOrder();
            });

            return $flights;
        }, $data);
    }
}
