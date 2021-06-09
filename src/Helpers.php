<?php
namespace XMLHosting\TravelAgency\FlightData;

use XMLHosting\TravelAgency\FlightData\Factories\Factory;

class Helpers
{

    public static function getInstance(string $factory, array $data)
    {
        $instance = self::createFactory($factory);

        return empty($instance) ? null : $instance->getInstance($data);
    }

    public static function getInstances(string $factory, array $data): array
    {
        $instance = self::createFactory($factory);

        return empty($instance) ? [] : $instance->getInstances($data);
    }

    public static function createFactory(string $factory): ?Factory
    {
        if (class_exists($factory) && in_array(Factory::class, class_implements($factory))) {
            return new $factory();
        }

        $class = __NAMESPACE__ . '\\Factories\\' . $factory;
        if (class_exists($class) && in_array(Factory::class, class_implements($class))) {
            return new $class();
        }

        return null;
    }

    public static function getProperty($needle, $haystack, $fallback = null)
    {
        if (is_array($needle)) {
            $value = $haystack;
            foreach ($needle as $unused) {
                $key = array_shift($needle);
                $value = self::getProperty($key, $value, $fallback);
            }
            return $value;
        }

        return is_array($haystack) && array_key_exists($needle, $haystack)
        ? $haystack[$needle] : $fallback;
    }

    public static function getQueryArgs(array $args = []): string
    {
        if (empty($args)) {
            return '';
        }

        return '?' . implode('&', $args);
    }

    public static function addTrailingSlash(string $value): string
    {
        return rtrim($value, '/') . '/';
    }

    public static function mapValueToKey(string $needle, array $haystack)
    {
        $search = array_search($needle, $haystack, true);
        if ($search !== false) {
            return $search;
        }

        $result = null;
        foreach ($haystack as $key => $subHaystack) {
            if (is_array($subHaystack) && in_array($needle, $subHaystack, true)) {
                $result = $key;
            }
        }

        return $result;
    }
}