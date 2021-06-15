<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Clients;

use XMLHosting\TravelAgency\FlightData\Clients\RyanAirClient;
use XMLHosting\TravelAgency\FlightData\Models\Trip;
use XMLHosting\TravelAgency\FlightData\Tests\BaseTest;

class RyanAirClientTest extends BaseTest
{
    /** @test */
    public function can_get_trips()
    {
        $today = new \DateTime();
        $add14Days = new \DateInterval('P14D.');
        $departOn = $today->add($add14Days);
        $returnOn = $departOn->add($add14Days);

        $client = new RyanAirClient();

        $req = $client->getTrips()
            ->origin('AMS')
            ->destination('DUB')
            ->departOn($departOn)
            ->returnOn($returnOn)
            ->adults(2);

        $res = $req->send();

        $expected = 200;
        $actual = $res->getStatusCode();
        $this->assertEquals($expected, $actual);

        $expected = 1;
        $actual = $res->getBody();
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = Trip::class;
        $actual = $res->getBody()[0];
        $this->assertInstanceOf($expected, $actual);
    }
}
