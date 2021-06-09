<?php
namespace XMLHosting\TravelAgency\FlightData\Factories;

use XMLHosting\TravelAgency\FlightData\Helpers;

abstract class BaseFactory implements Factory
{
    public function getInstances(array $data): array
    {
        return array_map(function ($item) {            
            return $this->getInstance($item);
        }, $data);
    }
}
