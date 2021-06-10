# Travel Agency: Flight Data

This package contains tools to manage flight data of several providers. Currently the following providers are supported:

- Transavia: Flight Offers API (v1);
- RyanAir: Public API.

In the following paragraphs will be explained how this package can be [installed](#installation), [configured](#configuration), [used](#usage) and/or [contributed to](#contribution).

## Installation

Before installing this package make sure the environment of your project meets the following prerequisites:

- [PHP](https://www.php.net/) 7.1 or higher is installed;
- [Composer](https://getcomposer.org/) 2 or higher is installed.

Then configure your project's `composer.json` file to contain the following [repository](https://getcomposer.org/doc/04-schema.md#repositories) and [require](https://getcomposer.org/doc/04-schema.md#require):

```json
{
  "require": {
    "xmlhosting/travel-agency-flight-data": "dev-master"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "github-travel-agency-flight-data:XMLHosting/travel-agency-flight-data.git"
    }
  ]
}
```

Next upload the SSH key, that gives you access to this repository, to the user's `~/.ssh` directory and add the following lines to the `~/.ssh/config` file:

```
Host github-travel-agency-flight-data
   HostName github.com
   User git
   IdentityFile ~/.ssh/github-travel-agency-flight-data
   IdentitiesOnly yes
```

Now you should be able to retrieve the package from GitHub by running:

```
composer install
```

After installing the package successfully you should be able to [configure the package](#configuration).

## Configuration

All the configuration that this package require is the configuration that is required for setting up a flight data provider. Configuration for this package is done via [environmental variables](https://en.wikipedia.org/wiki/Environment_variable). Please follow the following naming convention to configure a provider:

- `PROVIDER_BASE_URI`: The base URI of the API (required);
- `PROVIDER_CLIENT_ID`: An ID/username (usually optional);
- `PROVIDER_CLIENT_SECRET`: The secret/password/token/api key (optional for public API's).

Where `PROVIDER` can be one of the providers in the following table. The table also describes if the `CLIENT_ID` or `CLIENT_SECRET` variables is required for the given provider:

| PROVIDER  | CLIENT_ID | CLIENT_SECRET |
| --------- | --------- | ------------- |
| RYANAIR   | No        | No            |
| TRANSAVIA | No        | Yes           |

Also good to know, when setting the `BASE_URI`, is which resources are used by the different endpoints the clients in this package provide. Have a look at the table below:

| Client class    | `getTrips()`   |
| --------------- | -------------- |
| RyanAirClient   | `availability` |
| TransaviaClient | `flightoffers` |

In the next section, we will dive into how to [use this package](#usage).

## Usage

As told before, currently this package supports clients for several providers. All clients use the same interface and thus can generally be used in the same way. Below example with the `RyanAirClient` to demonstrate the general usage.

1. Initiate the client

   ```php
   use XMLHosting\TravelAgency\FlightData\Clients\RyanAirClient;

   $client = new RyanAirClient();
   ```

2. Prepare the parameters for the request

   ```php
   $fourteenDays = new \DateInterval('P14D.');
   $today = new \DateTime();
   $departOn = $today->add($fourteenDays);
   $returnOn = $departOn->add($fourteenDays);
   ```

3. Build the request and send it

   ```php
   $response = $client->getTrips()
       ->origin('AMS')
       ->destination('DUB')
       ->departOn($departOn)
       ->returnOn($returnOn)
       ->adults(2)
       ->send();
   ```

4. Read the response

   ```php
   if ($response->getStatusCode() !== 200) {
       die('Oops! Something went wrong');
   }

   $trips = $response->getBody();
   ```

5. Use the response

   ```php
   // Model: Trip
   $trip = $trips[0];
   $originName = $trip->getOrigin()->getName();
   $destinationCode = $trip->getDestination()->getCode();
   $flights = $trips->getFlights();

   // Flights with stops are grouped, e.g.:
   $fromOriginToStop = $flights[0][0];
   $fromStopToDestination = $flights[0][1];

   // Model: Flight
   $flight = $flights[0][0];
   $carrier = $flight->getCarrier();
   $flightNumber = $flight->getNumber();
   $departsAtLocal = $flight->getDepartsAtLocal();
   $departsAtUTC = $flight->getDepartsAtUTC();
   $arrivesAtLocal = $flight->getArrivesAtLocal();
   $arrivesAtUTC = $flight->getArrivesAtUTC();
   $duration = $flight->getDuration();
   $origin = $flight->getOrigin();           // Model: Airport
   $destination = $flight->getDestination(); // Model: Airport
   $passengers = $flight->getPassengers();

   // Model: Passenger
   $passenger = $passengers[0];
   $ageGroup = $passenger->getAgeGroup();
   $amount = $passenger->getAmount();
   $fares = $passenger->getFares();

   // Model: Fare
   $fare = $fares[0];
   $class = $fare->getClass();
   $price = $fare->getPrice();
   $currency = $fare->getCurrency();
   ```

## Contribution

To contribute to this project, please make sure you're implementing the right interfaces. Have a look at the other clients, all clients are build the same way:

- All clients extend the BaseClient;
- Each API call, defined in the Client interface, has a request and response interface dedicated to it;
- All response bodies are build by factories which are converting the raw data to domain specific models;
- In the factories most all the mapping from raw response body to actual domain model takes place.