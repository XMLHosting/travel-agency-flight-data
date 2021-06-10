<?php
namespace XMLHosting\TravelAgency\FlightData\Responses;

interface Response {
    public function getStatusCode(): int;

    public function getBody();
}