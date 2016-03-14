<?php

namespace SparkPost\Api\Proxy;

use SparkPost\Api\Client;

class Transmission
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(array $options)
    {
        // validate + translate

        $formatted = [
            "recipients" => $options["recipients"],
            "content" => [
                "html" => $options["html"],
                "from" => $options["from"],
                "subject" => $options["subject"],
            ],
        ];

        return $this->client->createTransmission($formatted);
    }
}
