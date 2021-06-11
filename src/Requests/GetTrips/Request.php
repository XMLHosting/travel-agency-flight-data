<?php
namespace XMLHosting\TravelAgency\FlightData\Requests\GetTrips;

use XMLHosting\TravelAgency\FlightData\Requests\Request as BaseRequest;
use \DateTime;

interface Request extends BaseRequest
{
    /**
     * Methods for configuring the trip's location
     */

    public function origin(string $airport): self;

    public function destination(string $airport): self;

    /**
     * Methods for configuring the travel period
     */

    public function departOn(DateTime $when): self;

    public function returnOn(DateTime $when): self;

    /**
     * Methods for configuring seating
     */

    public function newborns(int $amount): self;

    public function infants(int $amount): self;

    public function toddlers(int $amount): self;

    public function children(int $amount): self;

    public function teenagers(int $amount): self;

    public function adults(int $amount): self;

    public function seniors(int $amount): self;
}
