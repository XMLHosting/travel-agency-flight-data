<?php
namespace XMLHosting\TravelAgency\FlightData\Requests;

use XMLHosting\TravelAgency\FlightData\Requests\GetTripsRequest;

interface RequestMethods
{
    public function getTrips(): GetTripsRequest;
}