<?php
namespace XMLHosting\TravelAgency\FlightData\Responses;

use XMLHosting\TravelAgency\FlightData\Helpers;

class MergedResponse extends BaseResponse
{
    protected function parseBody($value) {
        return Helpers::mergeTrips($value);
    }
}