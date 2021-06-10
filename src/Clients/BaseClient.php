<?php
namespace XMLHosting\TravelAgency\FlightData\Clients;

use GuzzleHttp\Client as GuzzleClient;;

abstract class BaseClient extends GuzzleClient implements Client
{
    public function __construct() {
        parent::__construct($this->getDefaultConfig());
    }
}
