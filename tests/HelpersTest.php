<?php
namespace XMLHosting\TravelAgency\FlightData\Tests;

use XMLHosting\TravelAgency\FlightData\Helpers;

class HelpersTest extends BaseTest
{
    /** @test */
    public function can_get_property_of_first_level()
    {
        $expected = 'bar';

        $needle = 'first';
        $haystack = [$needle => $expected];

        $actual = Helpers::getProperty($needle, $haystack);

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function can_get_property_of_second_level()
    {
        $expected = 'bar';

        $needle = ['first', 'second'];
        $haystack = [$needle[0] => [$needle[1] => $expected]];

        $actual = Helpers::getProperty($needle, $haystack);

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function can_generate_query_string()
    {
        $input = [
            'string' => 'foo',
            'numeric' => 1.5,
            'bool' => false,
        ];

        $expected = '?string=foo&numeric=1.5&bool=false';
        $actual = Helpers::getQueryString($input);

        $this->assertEquals($expected, $actual);
    }
}
