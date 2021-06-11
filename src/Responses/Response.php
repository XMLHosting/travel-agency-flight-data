<?php
namespace XMLHosting\TravelAgency\FlightData\Responses;

interface Response {
    public function statusCode(int $value): self;

    public function isSuccessful(): bool;

    public function getStatusCode(): int;

    public function body($value): self;

    public function getBody();
}