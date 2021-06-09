<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\AirportDestinationFactory;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\AirportOriginFactory;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\FlightFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Trip;

class TripFactory extends BaseFactory
{
    const PROP_DATES = 'dates';
    const PROP_FLIGHTS = 'flights';

    public function getInstance(array $data)
    {
        $origin = Helpers::getInstance(AirportOriginFactory::class, $data);
        $destination = Helpers::getInstance(AirportDestinationFactory::class, $data);

        $flightData = self::getFlights($data);
        $flights = Helpers::getInstances(FlightFactory::class, $flightData);

        return Trip::build()
            ->origin($origin)
            ->destination($destination)
            ->flights($flights);
    }

    private static function getFlights(array $data): array
    {
        $dates = Helpers::getProperty(self::PROP_DATES, $data, []);

        $result = [];
        foreach ($dates as $date) {
            $flights = Helpers::getProperty(self::PROP_FLIGHTS, $date, []);
            $result = array_merge($result, $flights);
        }

        return $result;
    }
}
