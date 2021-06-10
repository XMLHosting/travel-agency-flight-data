<?php
namespace XMLHosting\TravelAgency\FlightData\Requests;

use \DateTime;

interface GetTripsRequest extends Request
{
    /**
     * Methods for configuring the trip's location
     */

    public function origin(string $airport): self;

    public function destination(string $airport): self;

    /**
     * Methods for configuring the travel period
     */

    public function departAt(DateTime $when): self;

    public function returnAt(DateTime $when): self;

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
