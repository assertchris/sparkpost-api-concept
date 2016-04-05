<?php

require("vendor/autoload.php");

use SparkPost\Api\Client;
use GuzzleHttp\Client as GuzzleClient;

$config = require("config.php");

$client = new Client(new GuzzleClient(), $config["spark-post"]["key"]);

 $result = $client->createTransmission([
     "content" => [
         "html" => "hello world",
         "from" => "sandbox@sparkpostbox.com",
         "subject" => "Hello world",
     ],
     "recipients" => [
         [
             "address" => [
                 "name" => "Chris",
                 "email" => "cgpitt@gmail.com",
             ],
         ],
     ],
 ]);

$result = $client->transmission->create([
    "html" => "hello world",
    "from" => "sandbox@sparkpostbox.com",
    "subject" => "Hello world",
    "recipients" => [
        [
            "address" => [
                "name" => "Chris",
                "email" => "cgpitt@gmail.com",
            ],
        ],
    ],
]);
