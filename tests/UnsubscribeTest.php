<?php
namespace Nikapps\BazaarApi\Tests;

use Nikapps\BazaarApi\Bazaar;
use Nikapps\BazaarApi\Client\ClientInterface;
use Nikapps\BazaarApi\Models\Unsubscribe;

class UnsubscribeTest extends TestCase
{
    /** @test */
    public function it_should_unsubscribe_a_subscription()
    {
        $bazaar = $this->makeBazaar();

        $this->setClient(
            'get',
            $this->makeUnsubscribeUrl('com.example.app', 'sub-id', 'purchase-123456'),
            [
                'query' => [
                    'access_token' => 'token-123456'
                ]
            ],
            []
        );
        $this->setStorage();

        $unsubscribe = $bazaar->unsubscribe('com.example.app', 'sub-id', 'purchase-123456');

        $this->assertFalse($unsubscribe->failed());
        $this->assertFalse($unsubscribe->hasError());
        $this->assertFalse($unsubscribe->notFound());
        $this->assertTrue($unsubscribe->found());
        $this->assertTrue($unsubscribe->successful());
    }

    /** @test */
    public function it_should_parse_not_found_response()
    {
        $unsubscribe = new Unsubscribe([
            "error" => "not_found",
            "error_description" => "The requested purchase is not found!",
        ]);

        $this->assertFalse($unsubscribe->found());
        $this->assertTrue($unsubscribe->failed());
        $this->assertTrue($unsubscribe->hasError());
        $this->assertTrue($unsubscribe->notFound());
        $this->assertFalse($unsubscribe->successful());
        $this->assertEquals('not_found', $unsubscribe->error());
        $this->assertEquals('The requested purchase is not found!', $unsubscribe->errorDescription());
    }

}