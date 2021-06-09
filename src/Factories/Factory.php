<?php
namespace XMLHosting\TravelAgency\FlightData\Factories;

interface Factory
{
    public function getInstance(array $data);
    
    public function getInstances(array $data): array;
}