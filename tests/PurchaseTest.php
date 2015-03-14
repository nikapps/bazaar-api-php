<?php namespace Nikapps\BazaarApiPhpTests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use Nikapps\BazaarApiPhp\BazaarApi;
use Nikapps\BazaarApiPhp\Models\Requests\PurchaseStatusRequest;
use Nikapps\BazaarApiPhp\Models\Responses\Purchase;
use Nikapps\BazaarApiPhpTests\Mocks\ApiMockResponse;
use Nikapps\BazaarApiPhpTests\Mocks\MockPurchaseResponse;
use Nikapps\BazaarApiPhpTests\Mocks\MockTokenManager;

class PurchaseTest extends TestCase {

    /**
     * test getting a purchase
     *
     * @test
     * @group bazaarApiPhp.purchase
     */
    public function getPurchaseTest() {

        $mockTokenManager = new MockTokenManager();

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $mockPurchaseResponse = new MockPurchaseResponse();
        $mock = new Mock([$mockPurchaseResponse->getSuccessfulPurchaseResponse()]);
        $client->getEmitter()->attach($mock);

        $purchaseStatusRequest = new PurchaseStatusRequest();
        $purchaseStatusRequest->setPackage('com.package.name');
        $purchaseStatusRequest->setProductId('product_id');
        $purchaseStatusRequest->setPurchaseToken('purchase_token');


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());
        $bazaarApi->setTokenManager($mockTokenManager);

        $purchase = $bazaarApi->getPurchase($purchaseStatusRequest);

        $this->assertEquals(Purchase::CONSUMPTION_STATUS_NOT_CONSUMED, $purchase->getConsumptionState());
        $this->assertEquals(Purchase::PURCHASE_STATUS_PURCHASED, $purchase->getPurchaseState());
        $this->assertEquals('something', $purchase->getDeveloperPayload());
        $this->assertEquals("androidpublisher#inappPurchase", $purchase->getKind());

        $diffTimestamp = abs($purchase->getPurchaseTime()->timestamp - 1414181378566 / 1000);
        $this->assertLessThan(1, $diffTimestamp);


    }

    /**
     * test getting a purchase which is not exist
     *
     * @test
     * @expectedException \Nikapps\BazaarApiPhp\Exceptions\NotFoundException
     * @group bazaarApiPhp.purchase
     */
    public function notFoundPurchaseTest() {
        $mockTokenManager = new MockTokenManager();

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $mockPurchaseResponse = new MockPurchaseResponse();
        $mock = new Mock([$mockPurchaseResponse->getNotFoundPurchaseResponse()]);
        $client->getEmitter()->attach($mock);

        $purchaseStatusRequest = new PurchaseStatusRequest();
        $purchaseStatusRequest->setPackage('com.package.name');
        $purchaseStatusRequest->setProductId('product_id');
        $purchaseStatusRequest->setPurchaseToken('not_found_purchase_token');


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());
        $bazaarApi->setTokenManager($mockTokenManager);

        $bazaarApi->getPurchase($purchaseStatusRequest);
    }

    /**
     * test getting a purchase which package name is invalid
     *
     * @test
     * @expectedException \Nikapps\BazaarApiPhp\Exceptions\InvalidPackageNameException
     * @group bazaarApiPhp.purchase
     */
    public function inValidPackageNameTest() {
        $mockTokenManager = new MockTokenManager();

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $apiMockResponse = new ApiMockResponse();
        $mock = new Mock([$apiMockResponse->getInvalidPackageNameResponse()]);
        $client->getEmitter()->attach($mock);

        $purchaseStatusRequest = new PurchaseStatusRequest();
        $purchaseStatusRequest->setPackage('com.package.invalid.name');
        $purchaseStatusRequest->setProductId('product_id');
        $purchaseStatusRequest->setPurchaseToken('purchase_token');


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());
        $bazaarApi->setTokenManager($mockTokenManager);

        $bazaarApi->getPurchase($purchaseStatusRequest);
    }
} 