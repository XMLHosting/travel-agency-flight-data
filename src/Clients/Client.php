<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use GuzzleHttp\ClientInterface as GuzzleClient;
use Psr\Http\Client\ClientInterface as HttpClient;
use XMLHosting\TravelAgency\FlightData\Requests\GetTripsRequest;

interface Client extends HttpClient, GuzzleClient
{
    public function getDefaultConfig(): array;

    public function getTrips(): GetTripsRequest;
}
