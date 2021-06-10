<?php
namespace XMLHosting\TravelAgency\FlightData\Models\Enums;

abstract class Classes extends BaseEnum
{
    const ECONOMY = 'y';
    const PREMIUM_ECONOMY = 'w';
    const BUSINESS = 'j';
    const FIRST = 'f';

    public static function getDefaultName(): string
    {
        return 'economy';
    }
}
