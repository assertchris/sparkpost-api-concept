<?php

namespace SparkPost\Api\Test;

use Mockery;
use Mockery\MockInterface;
use SparkPost\Api\Client;
use GuzzleHttp\Client as GuzzleClient;
use SparkPost\Api\Proxy\Transmission;

class ClientTest extends Test
{
    /**
     * @test
     */
    public function itCreatesTransmissions()
    {
        /** @var MockInterface|GuzzleClient $mock */
        $mock = Mockery::mock(GuzzleClient::class);

        $sendToGuzzleClient = [
            "headers" => [
                "Content-type" => "application/json",
                "Authorization" => "abc123",
            ],
            "body" => '{"options":{"open_tracking":true,"click_tracking":true}}',
        ];

        $mock->shouldReceive("request")
            ->with(
                Mockery::type("string"),
                Mockery::type("string"),
                $sendToGuzzleClient
            )
            ->andReturn($mock);

        $mock->shouldReceive("getBody")
            ->andReturn('{"foo":"bar"}');

        $client = new Client($mock, "abc123");

        $this->assertEquals(
            ["foo" => "bar"],
            $client->createTransmission()
        );
    }

    /**
     * @test
     */
    public function itCreatesTransmissionProxy()
    {
        /** @var MockInterface|GuzzleClient $mock */
        $mock = Mockery::mock(GuzzleClient::class);

        $client = new Client($mock, "abc123");

        $this->assertNull($client->foo);
        $this->assertInstanceOf(Transmission::class, $client->transmission);
    }
}
