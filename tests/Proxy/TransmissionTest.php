<?php

namespace SparkPost\Api\Test\Proxy;

use Mockery\MockInterface;
use SparkPost\Api\Client;
use Mockery;
use SparkPost\Api\Proxy\Transmission;
use SparkPost\Api\Test\Test;

class TransmissionTest extends Test
{
    /**
     * @test
     */
    public function itCanCreateTransmissions()
    {
        /** @var MockInterface|Client $mock */
        $mock = Mockery::mock(Client::class);

        $dataForClient = [
            "recipients" => "everybody",
            "html" => "<strong>the message</strong>",
            "from" => "somebody",
            "subject" => "the subject",
        ];

        $dataClientGets = [
            "recipients" => $dataForClient["recipients"],
            "content" => [
                "html" => $dataForClient["html"],
                "from" => $dataForClient["from"],
                "subject" => $dataForClient["subject"],
            ],
        ];

        $mock->shouldReceive("createTransmission")
            ->with($dataClientGets);

        $proxy = new Transmission($mock);
        $proxy->create($dataForClient);
    }
}
