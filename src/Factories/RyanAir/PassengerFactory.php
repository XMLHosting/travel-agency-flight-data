<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\FareFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Enums\AgeGroups;
use XMLHosting\TravelAgency\FlightData\Models\Passenger;

class PassengerFactory extends BaseFactory
{
    private $fares = [];

    const PROP_AGE_GROUP = 'type';
    const PROP_AMOUNT = 'count';

    public function getInstance(array $data)
    {
        $ageGroup = $this->getMappedAgeGroup($data);
        $amount = Helpers::getProperty(self::PROP_AMOUNT, $data);

        $fares = Helpers::getInstances(FareFactory::class, $this->fares);

        return Passenger::build()
            ->ageGroup($ageGroup)
            ->amount($amount)
            ->fares($fares);
    }

    public function getInstances(array $data): array
    {
        $this->fares = $data;
        return array_map(function ($item) use ($data) {
            return $this->getInstance($item);
        }, $data);
    }

    private function getMappedAgeGroup(array $data): string
    {
        $needle = Helpers::getProperty(self::PROP_AGE_GROUP, $data);

        $haystack = [
            AgeGroups::Adult => 'ADT',
            AgeGroups::Teenager => 'TEEN',
            AgeGroups::Child => 'CHD',
            AgeGroups::Infant => 'INF',
        ];

        return Helpers::mapValueToKey($needle, $haystack);
    }
}
