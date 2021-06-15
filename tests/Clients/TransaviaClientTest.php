<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Clients;

use XMLHosting\TravelAgency\FlightData\Clients\TransaviaClient;
use XMLHosting\TravelAgency\FlightData\Models\Trip;
use XMLHosting\TravelAgency\FlightData\Tests\BaseTest;

class TransaviaClientTest extends BaseTest
{
    /** @test */
    public function can_get_trips()
    {
        $today = new \DateTime('17-07-2021');
        $add14Days = new \DateInterval('P8D.');
        $departOn = $today->add($add14Days);
        $returnOn = $departOn->add($add14Days);

        $client = new TransaviaClient();

        $req = $client->getTrips()
            ->origin('AMS')
            ->destination('OPO')
            ->departOn($departOn)
            ->returnOn($returnOn)
            ->adults(2);

        $res = $req->send();

        $expected = 200;
        $actual = $res->getStatusCode();
        $this->assertEquals($expected, $actual);

        $expected = 2;
        $actual = $res->getBody();
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = Trip::class;
        $actual = $res->getBody()[0];
        $this->assertInstanceOf($expected, $actual);

        $format = '%h hour and %i minutes';
        $expected = '1 hour and 45 minutes';
        $actual = $res->getBody()[0]->getFlights()[0][0]->getDuration()->format($format);
        $this->assertEquals($expected, $actual);
    }
}
