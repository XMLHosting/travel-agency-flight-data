<?php
namespace XMLHosting\TravelAgency\FlightData\Models\Enums;

abstract class AgeGroups extends BaseEnum
{
    const Newborn = 0;
    const Infant = 1;
    const Toddler = 2;
    const Child = 3;
    const Teenager = 4;
    const Adult = 5;
    const Senior = 6;

    public static function getDefaultName(): string {
        return 'Adult';
    }
}