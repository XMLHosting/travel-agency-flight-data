<?php
namespace XMLHosting\TravelAgency\FlightData\Models;

class Airport extends BaseModel
{
    protected $code;
    protected $name;

    public function code(string $value): self
    {
        return $this->set('code', $value);
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function name(string $value): self
    {
        return $this->set('name', $value);
    }

    public function getName(): ?string
    {
        if (empty($this->name)) {
            return $this->code;
        }
        return $this->name;
    }
}
