<?php namespace Nikapps\BazaarApiPhpTests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use Nikapps\BazaarApiPhp\BazaarApi;
use Nikapps\BazaarApiPhp\Models\Requests\SubscriptionStatusRequest;
use Nikapps\BazaarApiPhpTests\Mocks\MockSubscriptionResponse;
use Nikapps\BazaarApiPhpTests\Mocks\MockTokenManager;

class SubscriptionTest extends TestCase {

    /**
     * test getting a subscription
     *
     * @test
     * @group bazaarApiPhp.subscription
     */
    public function getSubscriptionTest() {

        $mockTokenManager = new MockTokenManager();

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $mockSubscriptionResponse = new MockSubscriptionResponse();
        $mock = new Mock([$mockSubscriptionResponse->getSuccessfulSubscriptionResponse()]);
        $client->getEmitter()->attach($mock);

        $subscriptionStatusRequest = new SubscriptionStatusRequest();
        $subscriptionStatusRequest->setPackage('com.package.name');
        $subscriptionStatusRequest->setSubscriptionId('subscription_id');
        $subscriptionStatusRequest->setPurchaseToken('purchase_token');


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());
        $bazaarApi->setTokenManager($mockTokenManager);

        $subscription = $bazaarApi->getSubscription($subscriptionStatusRequest);

        $this->assertEquals(true, $subscription->isAutoRenewing());
        $this->assertEquals("androidpublisher#subscriptionPurchase", $subscription->getKind());

        $diffInitTimestamp = abs($subscription->getInitiationTime()->timestamp - 1414181378566 / 1000);
        $diffExpirationTimestamp = abs($subscription->getExpirationTime()->timestamp - 1435912745710 / 1000);
        $this->assertLessThan(1, $diffInitTimestamp);
        $this->assertLessThan(1, $diffExpirationTimestamp);

    }

    /**
     * test getting a subscription which is not exist
     *
     * @test
     * @expectedException \Nikapps\BazaarApiPhp\Exceptions\NotFoundException
     * @group bazaarApiPhp.subscription
     */
    public function notFoundSubscriptionTest() {
        $mockTokenManager = new MockTokenManager();

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $mockSubscriptionResponse = new MockSubscriptionResponse();
        $mock = new Mock([$mockSubscriptionResponse->getNotFoundSubscriptionResponse()]);
        $client->getEmitter()->attach($mock);

        $subscriptionStatusRequest = new SubscriptionStatusRequest();

        $subscriptionStatusRequest->setPackage('com.package.name')
            ->setSubscriptionId('subscription_id')
            ->setPurchaseToken('not_found_purchase_token');


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());
        $bazaarApi->setTokenManager($mockTokenManager);

        $bazaarApi->getSubscription($subscriptionStatusRequest);
    }


} 