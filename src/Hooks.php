<?php
namespace XMLHosting\TravelAgency\FlightData;

class Hooks
{
    private static $data = [];

    const PROP_PRIORITY = 'priority';
    const PROP_CALLBACK = 'callback';

    private static function get($name)
    {
        if (is_array(self::$data) && array_key_exists($name, self::$data)) {
            return self::$data[$name];
        }

        return null;
    }

    private static function set($name, $callbacks)
    {
        self::$data[$name] = $callbacks;
    }

    private static function load($name)
    {
        $callbacks = self::get($name);

        if (empty($callbacks)) {
            return [];
        }

        usort($callbacks, function ($a, $b) {
            return $a[self::PROP_PRIORITY] - $b[self::PROP_PRIORITY];
        });

        return array_map(function ($item) {
            return $item[self::PROP_CALLBACK];
        }, $callbacks);
    }

    public static function add(string $name, callable $callback, int $priority = 10)
    {
        $callbacks = self::get($name);
        $callbacks[] = [
            self::PROP_PRIORITY => $priority,
            self::PROP_CALLBACK => $callback,
        ];

        self::set($name, $callbacks);
    }

    public static function apply(string $name, array $args)
    {
        if (empty($args)) {
            return null;
        }
        $args = array_values($args);
        $value = $args[0];

        $callbacks = self::load($name, $args);
        if (empty($callbacks)) {
            return $value;
        }

        foreach ($callbacks as $callback) {
            $value = $args[0] = call_user_func_array($callback, $args);
        }

        return $value;
    }

    function do(string $name, array $args = []) {
        $callbacks = self::load($name, $args);
        if (!empty($callbacks)) {
            foreach ($callbacks as $callback) {
                call_user_func_array($callback, $args);
            }
        }
    }
}
