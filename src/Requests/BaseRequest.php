<?php
namespace XMLHosting\TravelAgency\FlightData\Requests;

use GuzzleHttp\Psr7\Request as GuzzleRequest;
use XMLHosting\TravelAgency\FlightData\Clients\Client;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Responses\Response;

abstract class BaseRequest implements Request
{
    protected $client;
    protected $queries = [];
    protected $headers = [];
    protected $body = [];

    private function __construct(Client $client)
    {
        $this->client = $client;
        $this->init();
    }

    public static function build(Client $client)
    {
        return new static($client);
    }

    public function send(): Response
    {
        $req = new GuzzleRequest(
            $this->getMethod(),
            $this->getURI() .
            $this->getQueries(),
            $this->getHeaders(),
            $this->getBody()
        );

        $res = $this->client->sendAsync($req)->wait();
        
        return $this->getResponseBuilder()
            ->statusCode($res->getStatusCode())
            ->body((string) $res->getBody());
    }

    public function getQueries(): string
    {
        return Helpers::getQueryString($this->queries);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return json_encode($this->body);
    }

    protected function init(): void {}

    protected function addQuery(string $name, $value): self
    {
        return $this->add('queries', $name, $value);
    }

    protected function addHeader(string $name, $value): self
    {
        return $this->add('headers', $name, $value);
    }

    protected function addBodyItem(string $name, $value): self
    {
        return $this->add('body', $name, $value);
    }

    private function add(string $group, string $name, $value): self
    {
        if (property_exists($this, $group) && (
            !array_key_exists($name, $this->{$group}) || $this->{$group}[$name] !== $value
        )) {
            $this->{$group}[$name] = $value;
        }

        return $this;
    }

    protected function getQuery(string $name, $fallback = null)
    {
        return $this->get('queries', $name, $fallback);
    }

    protected function getHeader(string $name, $fallback = null)
    {
        return $this->get('headers', $name, $fallback);
    }

    protected function getBodyItem(string $name, $fallback = null)
    {
        return $this->get('body', $name, $fallback);
    }

    private function get(string $group, string $name, $fallback = null)
    {
        if (property_exists($this, $group) && array_key_exists($name, $this->{$group})) {
            return $this->{$group}[$name];
        }

        return $fallback;
    }
}
