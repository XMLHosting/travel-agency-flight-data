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
        $name = trim(strtolower($name));

        return count(array_map(function ($constant) use ($name) {
            $constant = strtolower($constant);
            if ($constant === $name) {
                return true;
            }

            return preg_replace('/_/', ' ', $constant) === $name; 
        }, array_keys(self::getConstants()))) === 1;
    }

    public static function isValidValue($value)
    {
        $values = array_values(self::getConstants());

        $value = is_numeric($value) ? intval($value) : trim(strtolower($value));

        return in_array($value, $values, true);
    }

    public static function getName($value)
    {
        $name = false;
        if (self::isValidName($value)) {
            $name = $value;
        } elseif (self::isValidValue($value)) {
            $value = is_numeric($value) ? intval($value) : trim(strtolower($value));
            $name = array_search($value, self::getConstants(), true);
        }

        return strtolower($name !== false ? $name : static::getDefaultName());
    }
}
