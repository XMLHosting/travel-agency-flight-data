<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

interface Client
{
    public function send(string $method, $uri, array $args = [], $body = null): void;

    public function getClient(): HttpClient;

    public function getClientArgs(): array;

    public function getRequest(): Request;

    public function getResponse(): Response;

    public function getResponseStatus(): int;

    public function getResponseBody(): array;

    /**
     * Methods that should handle pre-defined calls
     */

    public function getTrips(array $args = []): array;
}
