<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use XMLHosting\TravelAgency\FlightData\Factories\RyanAir\Trips;
use XMLHosting\TravelAgency\FlightData\Helpers;
use XMLHosting\TravelAgency\FlightData\Hooks;
use XMLHosting\TravelAgency\FlightData\Models\Fare;

class RyanAirClient extends BaseClient
{
    const PROP_CURRENCY = 'currency';
    const PROP_TRIPS = 'trips';

    public function getClientArgs(): array
    {
        return [
            'base_uri' => Helpers::addTrailingSlash(getenv('RYANAIR_BASE_URI')),
        ];
    }

    public function getTrips(array $args = []): array
    {
        $this->send('GET', 'availability', $args);
        $status = $this->getResponseStatus();
        if ($status !== 200) {
            return [];
        }

        $body = $this->getResponseBody();

        Hooks::add(Fare::HOOK_GET_BASE_CURRENCY, function () use ($body) {
            return Helpers::getProperty(self::PROP_CURRENCY, $body);
        });

        $trips = Helpers::getProperty(self::PROP_TRIPS, $body, []);

        return Trips::getInstances($trips);
    }
}
