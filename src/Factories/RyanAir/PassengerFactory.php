<?php
namespace XMLHosting\TravelAgency\FlightData\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Factories\BaseFactory;
use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\FareFactory;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Models\Enums\AgeGroups;
use XMLHosting\TravelAgency\FlightData\Models\Passenger;

class PassengerFactory extends BaseFactory
{
    const PROP_AGE_GROUP = 'type';
    const PROP_AMOUNT = 'count';

    public function getInstance(array $data)
    {
        $ageGroup = $this->getMappedAgeGroup($data);
        $amount = Helpers::getProperty(self::PROP_AMOUNT, $data);

        $fares = Helpers::getInstances(FareFactory::class, [$data]);

        return Passenger::build()
            ->ageGroup($ageGroup)
            ->amount($amount)
            ->fares($fares);
    }

    private function getMappedAgeGroup(array $data): ?string
    {
        $needle = Helpers::getProperty(self::PROP_AGE_GROUP, $data);

        $haystack = [
            AgeGroups::ADULT => 'ADT',
            AgeGroups::TEENAGER => 'TEEN',
            AgeGroups::CHILD => 'CHD',
            AgeGroups::INFANT => 'INF',
        ];

        $result = array_search($needle, $haystack);

        return $result !== false ? $result : null;
    }
}
