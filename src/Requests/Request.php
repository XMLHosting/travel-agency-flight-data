<?php
namespace XMLHosting\TravelAgency\FlightData\Requests;

use XMLHosting\TravelAgency\FlightData\Responses\Response;

interface Request
{
    public function getMethod(): string;

    public function getURI(): string;

    public function getQueries(): string;

    public function getHeaders(): array;

    public function getBody(): string;

    public function getResponseBuilder(): Response;
    
    public function send(): Response;
}