<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Requests\GetTrips\RyanAirRequest as GetTripsRequest;
use XMLHosting\TravelAgency\FlightData\Requests\GetTrips\Request as GetTripsRequestInterface;

class RyanAirClient extends BaseClient
{
    public function getDefaultConfig(): array
    {
        return [
            'base_uri' => Helpers::addTrailingSlash(
                Helpers::getConfigProperty('RYANAIR_BASE_URI')
            ),
        ];
    }

    public function getAirlines(): array {
        return ['FR'];
    }

    public function getTrips(): GetTripsRequestInterface
    {
        return GetTripsRequest::build($this);
    }
}
