<?php
namespace Nikapps\BazaarApi\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Nikapps\BazaarApi\Client\GuzzleClient;

class GuzzleClientTest extends TestCase
{
    /** @test */
    public function it_should_send_a_get_request()
    {
        $guzzle = $this->prophesize(Client::class);

        $guzzle->get('http://example.com/', ['query' => ['q' => 'search']])
            ->willReturn(new Response(
                200,
                [],
                json_encode([
                    'key-one' => 'something',
                    'key-two' => 'something-else'
                ])
            ));

        $client = new GuzzleClient($guzzle->reveal());
        $response = $client->get('http://example.com/', [
            'query' => [
                'q' => 'search'
            ]
        ]);

        $this->assertEquals([
            'key-one' => 'something',
            'key-two' => 'something-else'
        ], $response);

    }

    /** @test */
    public function it_should_return_response_when_request_is_not_successful()
    {
        $guzzle = $this->prophesize(Client::class);

        $guzzle->get('http://example.com/', [])
            ->willReturn(new Response(
                404,
                [],
                json_encode([
                    'error' => 'not_found'
                ])
            ));

        $client = new GuzzleClient($guzzle->reveal());
        $response = $client->get('http://example.com/');

        $this->assertEquals([
            'error' => 'not_found'
        ], $response);
    }

    /** @test */
    public function it_should_send_a_post_request()
    {
        $guzzle = $this->prophesize(Client::class);

        $guzzle->post('http://example.com/', ['form_params' => ['username' => 'alibo']])
            ->willReturn(new Response(
                200,
                [],
                json_encode([
                    'key-one' => 'something',
                    'key-two' => 'something-else'
                ])
            ));

        $client = new GuzzleClient($guzzle->reveal());
        $response = $client->post('http://example.com/', [
            'form_params' => [
                'username' => 'alibo'
            ]
        ]);

        $this->assertEquals([
            'key-one' => 'something',
            'key-two' => 'something-else'
        ], $response);

    }

}