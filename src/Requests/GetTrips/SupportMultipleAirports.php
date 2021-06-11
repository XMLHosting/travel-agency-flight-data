<?php
namespace XMLHosting\TravelAgency\FlightData\Requests\GetTrips;

use XMLHosting\TravelAgency\FlightData\Responses\MergedResponse;
use XMLHosting\TravelAgency\FlightData\Responses\Response;

trait SupportMultipleAirports
{
    protected function addSupportForMultipleAirports(): Response
    {
        $pattern = '/[\s,;|]+/';
        $origins = preg_split($pattern, $this->origin);
        $destinations = preg_split($pattern, $this->destination);

        if (count($origins) <= 1 && count($destinations) <= 1) {
            return parent::send();
        }

        $responses = [];
        foreach ($origins as $origin) {
            $this->origin($origin);
            if (count($destinations) <= 1) {
                $responses[] = parent::send();
            } else {
                foreach ($destinations as $destination) {
                    $this->destination($destination);
                    $responses[] = parent::send();
                }
            }
        }

        $responses = array_filter($responses, function ($response) {
            return $response->isSuccessful();
        });
        $responsesCount = count($responses);

        if ($responsesCount === 1) {
            return reset($responses);
        }

        $mergedResponse = new MergedResponse();
        if ($responsesCount > 1) {
            return $mergedResponse->statusCode(200)->body($responses);
        }

        return $mergedResponse->statusCode(204);
    }
}
