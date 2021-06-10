<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\Transavia;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Factories\Transavia\AirportDestinationFactory;
use XMLHosting\TravelAgency\FlightData\Factories\Transavia\AirportOriginFactory;
use XMLHosting\TravelAgency\FlightData\Factories\Transavia\FlightFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Trip;

class TripFactory extends BaseFactory
{
    const PROP_ORIGIN = 'origin';
    const PROP_DESTINATION = 'destination';
    const PROP_FLIGHTS = 'flights';
    const PROP_OUTBOUND_FLIGHT = 'outboundFlight';
    const PROP_INBOUND_FLIGHT = 'inboundFlight';

    public function getInstance(array $data)
    {
        $origin = Helpers::getProperty(self::PROP_ORIGIN, $data);
        $destination = Helpers::getInstance(self::PROP_DESTINATION, $data);

        $flightData = Helpers::getInstance(self::PROP_FLIGHTS, $data);
        $flights = Helpers::getInstances(FlightFactory::class, $flightData);

        return Trip::build()
            ->origin($origin)
            ->destination($destination)
            ->flights($flights);
    }

    public function getInstances(array $data): array
    {
        $result = [];
        foreach ($data as $item) {
            $result = $this->transformTripData($result, Helpers::getProperty(self::PROP_OUTBOUND_FLIGHT, $item));
            $result = $this->transformTripData($result, Helpers::getProperty(self::PROP_INBOUND_FLIGHT, $item));
        }

        return parent::getInstances(array_values($result));
    }

    private function transformTripData(array $data, ?array $item): array
    {
        if (!empty($item)) {
            $origin = Helpers::getInstance(AirportOriginFactory::class, $item);
            $destination = Helpers::getInstance(AirportDestinationFactory::class, $item);
            $id = $origin->getCode() . '-' . $destination->getCode();

            $flights = array_key_exists($id, $data) && array_key_exists(self::PROP_FLIGHTS, $data[$id]) 
                ? array_merge($data[$id][self::PROP_FLIGHTS], [$item]) : [[$item]];

            $data[$id] = [
                self::PROP_ORIGIN => $origin,
                self::PROP_DESTINATION => $destination,
                self::PROP_FLIGHTS => $flights,
            ];
        }

        return $data;
    }
}
