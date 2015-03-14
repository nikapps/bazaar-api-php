<?php namespace Nikapps\BazaarApiPhpTests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use Nikapps\BazaarApiPhp\BazaarApi;
use Nikapps\BazaarApiPhp\Models\Requests\CancelSubscriptionRequest;
use Nikapps\BazaarApiPhpTests\Mocks\MockCancelSubscriptionResponse;
use Nikapps\BazaarApiPhpTests\Mocks\MockSubscriptionResponse;
use Nikapps\BazaarApiPhpTests\Mocks\MockTokenManager;

class CancelSubscriptionTest extends TestCase {

    /**
     * test getting a cancelSubscription
     *
     * @test
     * @group bazaarApiPhp.cancelSubscription
     */
    public function getCancelSubscriptionTest() {

        $mockTokenManager = new MockTokenManager();

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $mockCancelSubscriptionResponse = new MockCancelSubscriptionResponse();
        $mock = new Mock([$mockCancelSubscriptionResponse->getSuccessfulCancelSubscriptionResponse()]);
        $client->getEmitter()->attach($mock);

        $cancelSubscriptionRequest = new CancelSubscriptionRequest();
        $cancelSubscriptionRequest->setPackage('com.package.name');
        $cancelSubscriptionRequest->setSubscriptionId('subscription_id');
        $cancelSubscriptionRequest->setPurchaseToken('purchase_token');


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());
        $bazaarApi->setTokenManager($mockTokenManager);

        $cancelSubscription = $bazaarApi->cancelSubscription($cancelSubscriptionRequest);

        $this->assertEquals(true, $cancelSubscription->isCancelled());

    }

    /**
     * test getting a cancelSubscription which is not exist
     *
     * @test
     * @expectedException \Nikapps\BazaarApiPhp\Exceptions\NotFoundException
     * @group bazaarApiPhp.cancelSubscription
     */
    public function notFoundSubscriptionTest() {
        $mockTokenManager = new MockTokenManager();

        $client = new Client([
            $this->getApiConfig()->getBaseUrl()
        ]);

        $mockCancelSubscriptionResponse = new MockCancelSubscriptionResponse();
        $mock = new Mock([$mockCancelSubscriptionResponse->getNotFoundCancelSubscriptionResponse()]);
        $client->getEmitter()->attach($mock);

        $cancelSubscriptionRequest = new CancelSubscriptionRequest();

        $cancelSubscriptionRequest->setPackage('com.package.name')
            ->setSubscriptionId('subscription_id')
            ->setPurchaseToken('not_found_purchase_token');


        $bazaarApi = new BazaarApi();
        $bazaarApi->setClient($client);
        $bazaarApi->setApiConfig($this->getApiConfig());
        $bazaarApi->setAccountConfig($this->getAccountConfig());
        $bazaarApi->setTokenManager($mockTokenManager);

        $bazaarApi->cancelSubscription($cancelSubscriptionRequest);
    }
} 