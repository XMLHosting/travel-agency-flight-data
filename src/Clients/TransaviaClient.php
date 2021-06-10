<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Requests\Transavia\GetTripsRequest;
use XMLHosting\TravelAgency\FlightData\Requests\GetTripsRequest as GetTripsRequestInterface;

class TransaviaClient extends BaseClient
{
    public function getDefaultConfig(): array
    {
        return [
            'base_uri' => Helpers::addTrailingSlash(getenv('TRANSAVIA_BASE_URI')),
            'headers' => [
                'apiKey' => getenv('TRANSAVIA_API_KEY'),
            ]
        ];
    }

    public function getTrips(): GetTripsRequestInterface
    {
        return GetTripsRequest::build($this);
    }
}
