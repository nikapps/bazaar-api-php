<?php
namespace Nikapps\BazaarApi\Tests;

use Nikapps\BazaarApi\Bazaar;
use Nikapps\BazaarApi\Client\ClientInterface;
use Nikapps\BazaarApi\Models\Purchase;

class PurchaseTest extends TestCase
{

    /** @test */
    public function it_should_fetch_purchase_state()
    {
        $bazaar = $this->makeBazaar();

        $this->setClient(
            'get',
            $this->makePurchaseUrl('com.example.app', '123456', 'token-123456'),
            [
                'query' => [
                    'access_token' => 'token-123456'
                ]
            ],
            [
                "consumptionState" => 1,
                "purchaseState" => 0,
                "kind" => "androidpublisher#inappPurchase",
                "developerPayload" => "payload-123456",
                "purchaseTime" => 1414181378566
            ]
        );
        $this->setStorage();

        $purchase = $bazaar->purchase('com.example.app', '123456', 'token-123456');

        $this->assertTrue($purchase->purchased());
        $this->assertFalse($purchase->consumed());
        $this->assertEquals('payload-123456', $purchase->payload());

    }

    /** @test */
    public function purchase_should_parse_successful_response()
    {
        $purchase = new Purchase([
            "consumptionState" => 1,
            "purchaseState" => 0,
            "kind" => "androidpublisher#inappPurchase",
            "developerPayload" => "payload-123456",
            "purchaseTime" => 1414181378566
        ]);

        $this->assertTrue($purchase->found());
        $this->assertFalse($purchase->consumed());
        $this->assertTrue($purchase->purchased());
        $this->assertFalse($purchase->refunded());
        $this->assertFalse($purchase->failed());
        $this->assertFalse($purchase->hasError());
        $this->assertFalse($purchase->notFound());
        $this->assertEquals('payload-123456', $purchase->payload());
        $this->assertEquals('payload-123456', $purchase->developerPayload());
        $this->assertEquals(1414181378566, $purchase->time());
        $this->assertEquals('androidpublisher#inappPurchase', $purchase->kind());
    }

    /** @test */
    public function purchase_should_parse_not_found_response()
    {
        $purchase = new Purchase([
            "error" => "not_found",
            "error_description" => "The requested purchase is not found!",
        ]);

        $this->assertFalse($purchase->found());
        $this->assertTrue($purchase->failed());
        $this->assertTrue($purchase->hasError());
        $this->assertTrue($purchase->notFound());
        $this->assertEquals('not_found', $purchase->error());
        $this->assertEquals('The requested purchase is not found!', $purchase->errorDescription());
    }


}