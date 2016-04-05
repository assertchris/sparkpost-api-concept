<?php

namespace SparkPost\Api\Proxy;

use SparkPost\Api\Client;

class Transmission
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function create(array $options)
    {
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
