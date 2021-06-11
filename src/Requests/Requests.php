<?php
namespace XMLHosting\TravelAgency\FlightData\Requests;

use XMLHosting\TravelAgency\FlightData\Requests\GetTrips\Request as GetTripsRequestInterface;

interface Requests
{
    public function getTrips(): GetTripsRequestInterface;
}