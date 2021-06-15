<?php
namespace XMLHosting\TravelAgency\FlightData\Responses;

abstract class BaseResponse implements Response
{
    protected $statusCode = 500;
    protected $body;

    protected abstract function parseBody($body);

    public static function build()
    {
        return new static;
    }

    public function isSuccessful(): bool {
        return $this->getStatusCode() === 200 && !empty($this->getBody());
    }

    public function statusCode(int $value): self
    {
        return $this->set('statusCode', $value);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function body($value): self
    {
        $this->body = $value;

        if ($this->isSuccessful()) {
            $value = $this->parseBody($value);
        }

        return $this->set('body', $value);
    }

    public function getBody()
    {
        return $this->body;
    }

    protected function set(string $name, $value): self
    {
        if (property_exists($this, $name) && $this->{$name} !== $value) {
            $this->{$name} = $value;
        }

        return $this;
    }
}
