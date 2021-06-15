<?php
namespace XMLHosting\TravelAgency\FlightData\Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase {
    protected static function getJSONMock(string $fileName): array
    {
        $file = __DIR__ . '/Mocks/' . $fileName . '.json';

        if (!file_exists($file)) {
            throw new \Exception("File not found: $file");
        }

        $contents = file_get_contents($file);

        if (!$contents) {
            return [];
        }

        return json_decode($contents, true);
    }

}
