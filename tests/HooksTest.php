<?php
namespace XMLHosting\TravelAgency\FlightData\Tests;

use XMLHosting\TravelAgency\FlightData\Hooks;

class HooksTest extends BaseTest
{
    /** @test */
    function can_apply_hook_adding_before()
    {
        $name = 'test_apply_hook_before';

        $expectedFirst = 'foo';
        $expectedSecond = 'bar';
        
        Hooks::add($name, function ($actual) use ($expectedFirst, $expectedSecond) {
            $this->assertEquals($expectedFirst, $actual);

            return $expectedSecond;
        });

        $actual = Hooks::apply($name, [$expectedFirst]);

        $this->assertEquals($expectedSecond, $actual);
    }
}