<?php namespace Nikapps\BazaarApiPhpTests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use Nikapps\BazaarApiPhp\BazaarApi;
use Nikapps\BazaarApiPhp\Models\Requests\AuthorizationRequest;
use Nikapps\BazaarApiPhp\Models\Requests\PurchaseStatusRequest;
use Nikapps\BazaarApiPhp\Models\Requests\RefreshTokenRequest;
use Nikapps\BazaarApiPhp\Models\Responses\FetchRefreshToken;
use Nikapps\BazaarApiPhp\Models\Responses\Purchase;
use Nikapps\BazaarApiPhpTests\Mocks\ApiMockResponse;
use Nikapps\BazaarApiPhpTests\Mocks\MockPurchaseResponse;
use Nikapps\BazaarApiPhpTests\Mocks\MockTokenManager;

class TokenTest extends TestCase{

    /**
     * test getting new access token via refresh token
     *
     * @test
     * @group bazaarApiPhp.token
     */
    public function getNewAccessTokenTest() {

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $mockSubscriptionResponse = new ApiMockResponse();
        $mock = new Mock([$mockSubscriptionResponse->getSuccessfulRefreshTokenResponse()]);
        $client->getEmitter()->attach($mock);

        $authorizationRequest = new RefreshTokenRequest();


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());

        $fetchRefreshToken = $bazaarApi->refreshToken($authorizationRequest);

        $this->assertEquals('uX5qC82EGWjkjjeyvTzTufHOM9HZfM', $fetchRefreshToken->getAccessToken());
        $this->assertEquals(3600, $fetchRefreshToken->getExpireIn());
        $this->assertEquals("androidpublisher", $fetchRefreshToken->getScope());
        $this->assertEquals("Bearer", $fetchRefreshToken->getTokenType());

    }

    /**
     * test getting a refresh-token (authorization)
     *
     * @test
     * @group bazaarApiPhp.token
     */
    public function fetchRefreshTokenTest() {

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $mockSubscriptionResponse = new ApiMockResponse();
        $mock = new Mock([$mockSubscriptionResponse->getSuccessfulFetchRefreshTokenResponse()]);
        $client->getEmitter()->attach($mock);

        $authorizationRequest = new AuthorizationRequest();


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());

        $fetchRefreshToken = $bazaarApi->fetchRefreshToken($authorizationRequest);

        $this->assertEquals('GWObRK06KHLr8pCQzDXJ9hcDdSC3eV', $fetchRefreshToken->getAccessToken());
        $this->assertEquals('yBC4br1l6OCNWnahJvreOchIZ9B6ze', $fetchRefreshToken->getRefreshToken());
        $this->assertEquals(3600, $fetchRefreshToken->getExpireIn());
        $this->assertEquals("androidpublisher", $fetchRefreshToken->getScope());
        $this->assertEquals("Bearer", $fetchRefreshToken->getTokenType());

    }

    /**
     * test getting a purchase which access token is invalid
     *
     * @test
     * @expectedException \Nikapps\BazaarApiPhp\Exceptions\InvalidTokenException
     * @group bazaarApiPhp.token
     */
    public function inValidPackageNameTest() {
        $mockTokenManager = new MockTokenManager();
        $mockTokenManager->setAccessToken('invalid_access_token');

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $apiMockResponse = new ApiMockResponse();
        $mock = new Mock([$apiMockResponse->getInvalidAccessToken()]);
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

        $bazaarApi->getPurchase($purchaseStatusRequest);
    }

    /**
     * test getting a purchase which access token is expired
     *
     * @test
     * @expectedException \Nikapps\BazaarApiPhp\Exceptions\ExpiredAccessTokenException
     * @group bazaarApiPhp.token
     */
    public function expiredAccessTokenTest() {
        $mockTokenManager = new MockTokenManager();
        $mockTokenManager->setAccessToken('expired_access_token');

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $apiMockResponse = new ApiMockResponse();
        $mock = new Mock([$apiMockResponse->getExpiredAccessTokenResponse()]);
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

        $bazaarApi->getPurchase($purchaseStatusRequest);
    }

    /**
     * test getting new access token if tokenManager.isTokenExpired == true
     *
     * @test
     * @group bazaarApiPhp.token
     */
    public function autoGetNewAccessTokenTest() {
        $mockTokenManager = new MockTokenManager();
        $mockTokenManager->setAccessToken('expired_access_token');
        $mockTokenManager->setIsExpired(true);

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $apiMockResponse = new ApiMockResponse();
        $mockPurchaseResponse = new MockPurchaseResponse();

        $mock = new Mock([
            $apiMockResponse->getSuccessfulRefreshTokenResponse(),
            $mockPurchaseResponse->getSuccessfulPurchaseResponse()
        ]);

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

        $this->assertEquals('uX5qC82EGWjkjjeyvTzTufHOM9HZfM', $mockTokenManager->loadToken());

        $this->assertEquals(Purchase::CONSUMPTION_STATUS_NOT_CONSUMED, $purchase->getConsumptionState());
        $this->assertEquals(Purchase::PURCHASE_STATUS_PURCHASED, $purchase->getPurchaseState());
        $this->assertEquals('something', $purchase->getDeveloperPayload());
        $this->assertEquals("androidpublisher#inappPurchase", $purchase->getKind());

        $diffTimestamp = abs($purchase->getPurchaseTime()->timestamp - 1414181378566 / 1000);
        $this->assertLessThan(1, $diffTimestamp);


    }


} 