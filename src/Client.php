<?php

namespace SparkPost\Api;

use GuzzleHttp\Client as GuzzleClient;
use SparkPost\Api\Proxy\Transmission;

class Client
{
    /**
     * @var array
     */
    private $aliases = [
        "transmission" => Transmission::class,
    ];

    /**
     * @var array
     */
    private $proxies = [];

    /**
     * @var string
     */
    private $base = "https://api.sparkpost.com/api/v1";

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * @var string
     */
    private $key;

    /**
     * @param GuzzleClient $client
     * @param string $key
     */
    public function __construct(GuzzleClient $client, $key)
    {
        $this->client = $client;
        $this->key = $key;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function createTransmission(array $options = [])
    {
        $options = array_replace_recursive([
            "options" => [
                "open_tracking" => true,
                "click_tracking" => true,
            ],
        ], $options);

        return $this->request("POST", "transmissions", $options);
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $options
     *
     * @return array
     */
    private function request($method, $endpoint, array $options = [])
    {
        $response = $this->client->request($method, $this->base . "/" . $endpoint, [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => $this->key,
            ],
            "body" => json_encode($options),
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (isset($this->aliases[$property])) {
            if (!isset($this->proxies[$property])) {
                $class = $this->aliases[$property];
                $this->proxies[$property] = new $class($this);
            }

            return $this->proxies[$property];
        }
    }
}
