<?php
namespace XMLHosting\TravelAgency\FlightData\Requests\Transavia;

use DateTime;
use XMLHosting\TravelAgency\FlightData\Responses\Response;
use XMLHosting\TravelAgency\FlightData\Requests\BaseRequest;
use XMLHosting\TravelAgency\FlightData\Responses\Transavia\GetTripsResponse;
use XMLHosting\TravelAgency\FlightData\Requests\GetTripsRequest as GetTripsRequestInterface;

class GetTripsRequest extends BaseRequest implements GetTripsRequestInterface
{
    const SEARCH_IN_DAY_DATE_FORMAT = 'Ymd';
    const SEARCH_IN_MONTH_DATE_FORMAT = 'Ym';

    protected $dateFormat = self::SEARCH_IN_DAY_DATE_FORMAT;

    public function searchInDay(bool $value = true) {
        if ($value) {
            $this->dateFormat = self::SEARCH_IN_DAY_DATE_FORMAT;
        }
    }

    public function searchInMonth(bool $value = true) {
        if ($value) {
            $this->dateFormat = self::SEARCH_IN_MONTH_DATE_FORMAT;
        }
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getURI(): string
    {
        return 'flightoffers';
    }

    public function getResponseBuilder(): Response
    {
        return GetTripsResponse::build();
    }

    public function origin(string $airport): self
    {
        return $this->addQuery('origin', $airport);
    }

    public function destination(string $airport): self
    {
        return $this->addQuery('destination', $airport);
    }

    public function departOn(DateTime $when): self
    {
        return $this->addQuery('originDepartureDate', $when->format($this->dateFormat));
    }

    public function returnOn(DateTime $when): self
    {
        return $this->addQuery('destinationDepartureDate', $when->format($this->dateFormat));
    }

    public function newborns(int $amount): self
    {
        return $this->addSeating('children', $amount);
    }

    public function infants(int $amount): self
    {
        return $this->addSeating('children', $amount);
    }

    public function toddlers(int $amount): self
    {
        return $this->addSeating('children', $amount);
    }

    public function children(int $amount): self
    {
        return $this->addSeating('children', $amount);
    }

    public function teenagers(int $amount): self
    {
        return $this->addSeating('adults', $amount);
    }

    public function adults(int $amount): self
    {
        return $this->addSeating('adults', $amount);
    }

    public function seniors(int $amount): self
    {
        return $this->addSeating('adults', $amount);
    }

    private function addSeating(string $name, int $amount): self
    {
        $currentAmount = $this->getQuery($name, 0);

        return $this->addQuery($name, $currentAmount + $amount);
    }
}
