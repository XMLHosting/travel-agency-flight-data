<?php
namespace XMLHosting\TravelAgency\FlightData\Models\Enums;

abstract class BaseEnum
{
    abstract public static function getDefaultName(): string;

    private static $constCacheArray = null;

    private static function getConstants()
    {
        if (self::$constCacheArray == null) {
            self::$constCacheArray = [];
        }

        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }

        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name)
    {
        $keys = array_map('strtolower', array_keys(self::getConstants()));

        return in_array(strtolower($name), $keys, true);
    }

    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());

        return in_array(intval($value), $values, true);
    }

    public static function getName($value)
    {
        $name = false;
        if (self::isValidName($value)) {
            $name = $value;
        } elseif (self::isValidValue($value)) {
            $name = array_search(intval($value), self::getConstants(), true);
        }

        return strtolower($name !== false ? $name : static::getDefaultName());
    }
}
