<?php
namespace XMLHosting\TravelAgency\FlightData\Models\Enums;

abstract class AgeGroups extends BaseEnum
{
    const NEWBORN = 0;
    const INFANT = 1;
    const TODDLER = 2;
    const CHILD = 3;
    const TEENAGER = 4;
    const ADULT = 5;
    const SENIOR = 6;

    public static function getDefaultName(): string {
        return 'adult';
    }
}