<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Requests\GetTripsRequest as GetTripsRequestInterface;
use XMLHosting\TravelAgency\FlightData\Requests\Transavia\GetTripsRequest;

class TransaviaClient extends BaseClient
{
    public function getDefaultConfig(): array
    {
        return [
            'base_uri' => Helpers::addTrailingSlash(
                Helpers::getConfigProperty('TRANSAVIA_BASE_URI')
            ),
            'headers' => [
                'apiKey' => Helpers::getConfigProperty('TRANSAVIA_CLIENT_SECRET'),
            ],
        ];
    }

    public function getTrips(): GetTripsRequestInterface
    {
        return GetTripsRequest::build($this);
    }
}
