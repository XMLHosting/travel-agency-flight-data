<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use GuzzleHttp\ClientInterface as GuzzleClient;
use Psr\Http\Client\ClientInterface as HttpClient;
use XMLHosting\TravelAgency\FlightData\Requests\RequestMethods;

interface Client extends RequestMethods, HttpClient, GuzzleClient
{
    public function getDefaultConfig(): array;

    public function getAirlines(): array;
}
