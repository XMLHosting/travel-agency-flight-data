<?php
namespace XMLHosting\TravelAgency\FlightData\Models;

class Trip extends BaseModel
{
    protected $origin;
    protected $destination;
    protected $flights = [];

    public function origin(Airport $value): self
    {
        return $this->set('origin', $value);
    }

    public function getOrigin(): ?Airport
    {
        return $this->origin;
    }

    public function destination(Airport $value): self
    {
        return $this->set('destination', $value);
    }

    public function getDestination(): ?Airport
    {
        return $this->destination;
    }

    public function flights(array $value): self
    {
        return $this->set('flights', $value);
    }

    public function getFlights(): array
    {
        return $this->flights;
    }
}
