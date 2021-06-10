<?php
namespace XMLHosting\TravelAgency\FlightData\Models;

abstract class BaseModel
{
    public static function build()
    {
        return new static;
    }

    protected function set(string $name, $value): self
    {
        if (property_exists($this, $name) && $this->{$name} !== $value) {
            $this->{$name} = $value;
        }

        return $this;
    }
}
