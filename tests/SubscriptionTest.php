<?php
namespace Nikapps\BazaarApi\Tests;

use Nikapps\BazaarApi\Bazaar;
use Nikapps\BazaarApi\Client\ClientInterface;
use Nikapps\BazaarApi\Models\Subscription;

class SubscriptionTest extends TestCase
{

    /** @test */
    public function it_should_fetch_subscription_state()
    {
        $bazaar = $this->makeBazaar();

        $this->setClient(
            'get',
            $this->makeSubscriptionUrl('com.example.app', 'sub-id', 'purchase-123456'),
            [
                'query' => [
                    'access_token' => 'token-123456'
                ]
            ],
            [
                "kind" => "androidpublisher#subscriptionPurchase",
                "initiationTimestampMsec" => 1000000000000,
                "validUntilTimestampMsec" => 1100000000000,
                "autoRenewing" => true,
            ]
        );
        $this->setStorage();

        $subscription = $bazaar->subscription('com.example.app', 'sub-id', 'purchase-123456');

        $this->assertEquals(1000000000000, $subscription->startTime());
        $this->assertEquals(1100000000000, $subscription->endTime());
        $this->assertTrue($subscription->autoRenewing());
        $this->assertTrue($subscription->expired());
    }

    /** @test */
    public function subscription_should_parse_successfully_response()
    {
        $tomorrow = (time() + (24 * 3600)) * 1000; // convert to ms

        $subscription = new Subscription([
            "kind" => "androidpublisher#subscriptionPurchase",
            "initiationTimestampMsec" => 1000000000000,
            "validUntilTimestampMsec" => $tomorrow,
            "autoRenewing" => true,
        ]);

        $this->assertTrue($subscription->found());
        $this->assertFalse($subscription->notFound());
        $this->assertFalse($subscription->hasError());
        $this->assertFalse($subscription->failed());
        $this->assertFalse($subscription->expired());
        $this->assertTrue($subscription->autoRenewing());
        $this->assertEquals(1000000000000, $subscription->startTime());
        $this->assertEquals(1000000000000, $subscription->initiationTime());
        $this->assertEquals($tomorrow, $subscription->endTime());
        $this->assertEquals($tomorrow, $subscription->expirationTime());
        $this->assertEquals($tomorrow, $subscription->nextTime());
        $this->assertEquals('androidpublisher#subscriptionPurchase', $subscription->kind());
    }

    /** @test */
    public function it_should_parse_not_found_response()
    {
        $subscription = new Subscription([
            "error" => "not_found",
            "error_description" => "The requested purchase is not found!",
        ]);

        $this->assertFalse($subscription->found());
        $this->assertTrue($subscription->failed());
        $this->assertTrue($subscription->hasError());
        $this->assertTrue($subscription->notFound());
        $this->assertEquals('not_found', $subscription->error());
        $this->assertEquals('The requested purchase is not found!', $subscription->errorDescription());
    }
}
