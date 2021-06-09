<?php
namespace XMLHosting\TravelAgency\FlightData\Models;

use XMLHosting\TravelAgency\FlightData\Hooks;

class Fare extends BaseModel
{
    const HOOK_GET_BASE_CLASS = 'get_base_class';
    const HOOK_GET_BASE_CURRENCY = 'get_base_currency';

    protected $class;
    protected $price;
    protected $currency;

    public function class(string $value): self
    {
        return $this->set('class', $value);
    }

    public function getClass(): ?string
    {
        if (empty($this->class)) {
            $this->class = Hooks::apply(self::HOOK_GET_BASE_CLASS, [null]);
            return $this->class;
        }

        return $this->class;
    }

    public function price(float $value): self
    {
        return $this->set('price', $value);
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function currency(string $value): self
    {
        return $this->set('currency', $value);
    }

    public function getCurrency(): ?string
    {
        if (empty($this->currency)) {
            $this->currency = Hooks::apply(self::HOOK_GET_BASE_CURRENCY, [null]);
            return $this->currency;
        }

        return $this->currency;
    }
}
