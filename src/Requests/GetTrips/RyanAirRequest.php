<?php
namespace XMLHosting\TravelAgency\FlightData\Requests\GetTrips;

use DateTime;
use XMLHosting\TravelAgency\FlightData\Requests\BaseRequest;
use XMLHosting\TravelAgency\FlightData\Requests\GetTrips\Request;
use XMLHosting\TravelAgency\FlightData\Requests\GetTrips\SupportMultipleAirports;
use XMLHosting\TravelAgency\FlightData\Responses\GetTrips\RyanAirResponse;
use XMLHosting\TravelAgency\FlightData\Responses\Response;

class RyanAirRequest extends BaseRequest implements Request
{
    use SupportMultipleAirports;

    const DATE_FORMAT = 'Y-m-d';

    private $origin;
    private $destination;

    protected function init(): void
    {
        $this->addQuery('ToUs', 'AGREED');
    }

    public function send(): Response
    {
        return $this->addSupportForMultipleAirports();
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getURI(): string
    {
        return 'availability';
    }

    public function getResponseBuilder(): Response
    {
        return RyanAirResponse::build();
    }

    public function origin(string $airport): self
    {
        $this->origin = $airport;

        return $this->addQuery('Origin', $airport);
    }

    public function destination(string $airport): self
    {
        $this->destination = $airport;

        return $this->addQuery('Destination', $airport);
    }

    public function departOn(DateTime $when): self
    {
        return $this->addQuery('DateOut', $when->format(self::DATE_FORMAT));
    }

    public function returnOn(DateTime $when): self
    {
        $this->addQuery('RoundTrip', 'true');
        return $this->addQuery('DateIn', $when->format(self::DATE_FORMAT));
    }

    public function newborns(int $amount): self
    {
        return $this->addSeating('INF', $amount);
    }

    public function infants(int $amount): self
    {
        return $this->addSeating('INF', $amount);
    }

    public function toddlers(int $amount): self
    {
        return $this->addSeating('CHD', $amount);
    }

    public function children(int $amount): self
    {
        return $this->addSeating('CHD', $amount);
    }

    public function teenagers(int $amount): self
    {
        return $this->addSeating('TEEN', $amount);
    }

    public function adults(int $amount): self
    {
        return $this->addSeating('ADT', $amount);
    }

    public function seniors(int $amount): self
    {
        return $this->addSeating('ADT', $amount);
    }

    private function addSeating(string $name, int $amount): self
    {
        $currentAmount = $this->getQuery($name, 0);

        return $this->addQuery($name, $currentAmount + $amount);
    }
}
