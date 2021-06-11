<?php
namespace XMLHosting\TravelAgency\FlightData;

use Dotenv\Dotenv;
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

    public static function getConfigProperty(string $needle, $fallback = null)
    {
        $env = getenv($needle);
        if (!empty($env)) {
            return $env;
        }

        $dir = getenv('APP_ROOT');
        if (empty($dir)) {
            $parts = explode('/vendor', __DIR__);
            $dir = $parts[0];
        }

        $dotenv = Dotenv::createImmutable($dir);
        $dotenv->load();

        return array_key_exists($needle, $_ENV) ? $_ENV[$needle] : $fallback;
    }

    public static function getQueryString(array $args = []): string
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

    public static function mergeTrips(array $getTripsResponses): array
    {
        $getTripsResponses = array_filter(array_values($getTripsResponses));
        if (count($getTripsResponses) <= 1) {
            return $getTripsResponses[0];
        }

        $result = [];
        foreach ($getTripsResponses as $getTripsResponse) {
            foreach ($getTripsResponse as $trip) {
                $origin = $trip->getOrigin()->getCode();
                $destination = $trip->getDestination()->getCode();
                $key = $origin . '-' . $destination;

                $flights = $trip->getFlights();
                if (array_key_exists($key, $result)) {
                    $flights = array_merge($result[$key]->getFlights(), $flights);
                }

                $result[$key] = $trip->flights($flights);
            }
        }

        return $result;
    }
}
