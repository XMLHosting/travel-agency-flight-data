<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use XMLHosting\TravelAgency\FlightData\Helpers;

abstract class BaseClient implements Client
{
    protected $client;
    protected $request;
    protected $response;

    public function __construct() {
        $this->client = new HttpClient($this->getClientArgs());
    }

    public function getClient(): HttpClient
    {
        return $this->client;
    }

    public function send(string $method, $uri, array $args = [], $body = null): void
    {
        $query = Helpers::getQueryArgs($args);
        $this->request = new Request($method, $uri . $query, [], $body);
        $this->response = $this->getClient()->sendAsync($this->request)->wait();
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {  
        return $this->response;
    }

    public function getResponseStatus(): int
    {
        return $this->response->getStatusCode();
    }

    public function getResponseBody(): array
    {
        return json_decode((string) $this->response->getBody(), true);
    }
}
