<?php
namespace XMLHosting\TravelAgency\FlightData\Models;

use \DateTime;
use \DateInterval;

class Flight extends BaseModel
{
    protected $order;
    protected $number;
    protected $carrier;
    protected $origin;
    protected $destination;
    protected $departsAtUTC;
    protected $departsAtLocal;
    protected $arrivesAtUTC;
    protected $arrivesAtLocal;
    protected $duration;
    protected $passengers = [];

    public function order(int $value): self
    {
        return $this->set('order', $value);
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function number(int $value): self
    {
        return $this->set('number', $value);
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function carrier(string $value): self
    {
        return $this->set('carrier', $value);
    }

    public function getCarrier(): string
    {
        return $this->carrier;
    }

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

    public function departsAtUTC(DateTime $value): self
    {
        return $this->set('departsAtUTC', $value);
    }

    public function getDepartsAtUTC(): ?DateTime
    {
        if (empty($this->departsAtUTC)) {
            if (empty($this->duration) || empty($this->arrivesAtUTC)) {
                return null;
            }
    
            $this->departsAtUTC = $this->arrivesAtUTC->sub($this->duration);
        }

        return $this->departsAtUTC;
    }

    public function departsAtLocal(DateTime $value): self
    {
        return $this->set('departsAtLocal', $value);
    }

    public function getDepartsAtLocal(): ?DateTime
    {
        if (empty($this->departsAtLocal)) {
            if (empty($this->duration) || empty($this->arrivesAtLocal)) {
                return null;
            }
    
            $this->departsAtLocal = $this->arrivesAtLocal->sub($this->duration);
        }

        return $this->departsAtLocal;
    }

    public function arrivesAtUTC(DateTime $value): self
    {
        return $this->set('arrivesAtUTC', $value);
    }

    public function getArrivesAtUTC(): ?DateTime
    {
        if (empty($this->arrivesAtUTC)) {
            if (empty($this->duration) || empty($this->departsAtUTC)) {
                return null;
            }
    
            $this->arrivesAtUTC = $this->departsAtUTC->add($this->duration);
        }

        return $this->arrivesAtUTC;
    }

    public function arrivesAtLocal(DateTime $value): self
    {
        return $this->set('arrivesAtLocal', $value);
    }

    public function getArrivesAtLocal(): ?DateTime
    {
        if (empty($this->arrivesAtLocal)) {
            if (empty($this->duration) || empty($this->departsAtLocal)) {
                return null;
            }
    
            $this->arrivesAtLocal = $this->departsAtLocal->add($this->duration);
        }

        return $this->arrivesAtLocal;
    }

    public function duration(DateInterval $value): self
    {
        return $this->set('duration', $value);
    }

    public function getDuration(): ?DateInterval
    {
        if (empty($this->duration) && !empty($this->departsAtUTC) && !empty($this->arrivesAtUTC)) {
            $this->duration = $this->departsAtUTC->diff($this->arrivesAtUTC);
        }

        return $this->duration;
    }

    public function passengers(array $value): self
    {
        return $this->set('passengers', $value);
    }

    public function getPassengers(): array
    {
        return $this->passengers;
    }
}
