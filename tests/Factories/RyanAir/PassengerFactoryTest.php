<?php
namespace XMLHosting\TravelAgency\FlightData\Tests\Factories\RyanAir;

use XMLHosting\TravelAgency\FlightData\Models\Passenger;

class PassengerFactoryTest extends BaseFactoryTest
{
    private static $passengers;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        self::$passengers = self::$trips[0]->getFlights()[0][0]->getPassengers();
    }

    /** @test */
    public function can_get_instances()
    {
        $expected = 1;
        $actual = self::$passengers;
        $this->assertIsArray($actual);
        $this->assertCount($expected, $actual);

        $expected = Passenger::class;
        $actual = self::$passengers[0];
        $this->assertInstanceOf($expected, $actual);

        $expected = 'adult';
        $actual = self::$passengers[0]->getAgeGroup();
        $this->assertEquals($expected, $actual);

        $expected = 1;
        $actual = self::$passengers[0]->getAmount();
        $this->assertEquals($expected, $actual);
    }
}
