<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\Transavia;

use XMLHosting\TravelAgency\FlightData\Models\Airport;
use XMLHosting\TravelAgency\FlightData\Models\Trip;

class TripFactoryTest extends BaseFactoryTest
{

    /** @test */
    public function can_get_instances()
    {
        $expected = 2;
        $actual = self::$trips;
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = Trip::class;
        $actual = self::$trips[0];
        $this->assertInstanceOf($expected, $actual);

        $expected = Airport::class;
        $actual = self::$trips[0]->getOrigin();
        $this->assertInstanceOf($expected, $actual);

        $expected = Airport::class;
        $actual = self::$trips[0]->getDestination();
        $this->assertInstanceOf($expected, $actual);
    }
}
