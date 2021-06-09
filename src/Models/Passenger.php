<?php
namespace XMLHosting\TravelAgency\FlightData\Models;

use XMLHosting\TravelAgency\FlightData\Models\Enums\AgeGroups;

class Passenger extends BaseModel
{
    protected $amount = 1;
    protected $ageGroup;
    protected $fares = [];

    public function amount(int $value): self
    {
        return $this->set('amount', $value);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function ageGroup($value): self
    {
        return $this->set('ageGroup', AgeGroups::getName($value));
    }

    public function getAgeGroup(): string
    {
        return $this->ageGroup;
    }

    public function fares(array $value): self
    {
        return $this->set('fares', $value);
    }

    public function getFares(): array
    {
        return $this->fares;
    }
}
