<?php namespace Nikapps\BazaarApiPhp;

use GuzzleHttp\Client;
use Nikapps\BazaarApiPhp\Configs\AccountConfig;
use Nikapps\BazaarApiPhp\Configs\ApiConfig;
use Nikapps\BazaarApiPhp\Models\Requests\AuthorizationRequest;
use Nikapps\BazaarApiPhp\Models\Requests\BazaarApiRequest;
use Nikapps\BazaarApiPhp\Models\Requests\CancelSubscriptionRequest;
use Nikapps\BazaarApiPhp\Models\Requests\PurchaseStatusRequest;
use Nikapps\BazaarApiPhp\Models\Requests\RefreshTokenRequest;
use Nikapps\BazaarApiPhp\Models\Requests\SubscriptionStatusRequest;
use Nikapps\BazaarApiPhp\Models\Responses\RefreshToken;
use Nikapps\BazaarApiPhp\TokenManagers\TokenManagerInterface;

class BazaarApi {


    /**
     * @var ApiConfig
     */
    protected $apiConfig;

    /**
     * @var AccountConfig
     */
    protected $accountConfig;

    /**
     * @var TokenManagerInterface
     */
    protected $tokenManager;

    /**
     * @var Client
     */
    protected $client;

    function __construct(AccountConfig $accountConfig = null) {

        if ($accountConfig == null) {
            $accountConfig = new AccountConfig();
        }
        $this->accountConfig = $accountConfig;
        $this->apiConfig = new ApiConfig();

    }

    /**
     * @return AccountConfig
     */
    public function getAccountConfig() {
        return $this->accountConfig;
    }

    /**
     * @param AccountConfig $accountConfig
     * @return $this
     */
    public function setAccountConfig($accountConfig) {
        $this->accountConfig = $accountConfig;

        return $this;
    }

    /**
     * @return ApiConfig
     */
    public function getApiConfig() {
        return $this->apiConfig;
    }

    /**
     * @param ApiConfig $apiConfig
     * @return $this
     */
    public function setApiConfig($apiConfig) {
        $this->apiConfig = $apiConfig;

        return $this;
    }

    /**
     * @return Client
     */
    public function getClient() {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return $this
     */
    public function setClient($client) {
        $this->client = $client;

        return $this;
    }

    /**
     * @return TokenManagerInterface
     */
    public function getTokenManager() {
        return $this->tokenManager;
    }

    /**
     * @param TokenManagerInterface $tokenManager
     * @return $this
     */
    public function setTokenManager($tokenManager) {
        $this->tokenManager = $tokenManager;

        return $this;
    }


    /**
     * fetch refresh-token itself (authorization request)
     *
     * @param AuthorizationRequest $authorizationRequest
     * @param callable $callback = null (optional)
     * @return Models\Responses\FetchRefreshToken
     * @throws Exceptions\NetworkErrorException
     * @throws Exceptions\InvalidJsonException
     */
    public function fetchRefreshToken(AuthorizationRequest $authorizationRequest, \Closure $callback = null) {

        $this->prepare($authorizationRequest);

        $bazaarApiClient = new BazaarApiClient();
        $bazaarApiClient->setClient($this->client);
        $bazaarApiClient->setRequest($authorizationRequest);

        $requestOptions = $this->getRequestOptionsForPost($authorizationRequest->getPostData());

        $bazaarApiClient->setRequestOptions($requestOptions);

        $fetchRefreshToken = $bazaarApiClient->request();

        if ($callback != null) {
            $callback($fetchRefreshToken);
        }

        return $fetchRefreshToken;
    }


    /**
     * get purchase status
     *
     * @param PurchaseStatusRequest $purchaseStatusRequest
     * @param callable $callback = null (optional)
     * @return Models\Responses\Purchase
     * @throws Exceptions\ExpiredAccessTokenException
     * @throws Exceptions\InvalidPackageNameException
     * @throws Exceptions\InvalidTokenException
     * @throws Exceptions\NetworkErrorException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\InvalidJsonException
     */
    public function getPurchase(PurchaseStatusRequest $purchaseStatusRequest, \Closure $callback = null) {

        $this->prepare($purchaseStatusRequest);
        $this->checkToken();

        $bazaarApiClient = new BazaarApiClient();
        $bazaarApiClient->setClient($this->client);
        $bazaarApiClient->setRequest($purchaseStatusRequest);

        $requestOptions = $this->getRequestOptionsForGet();

        $bazaarApiClient->setRequestOptions($requestOptions);

        $purchase = $bazaarApiClient->request();

        if ($callback != null) {
            $callback($purchase);
        }

        return $purchase;

    }

    /**
     * cancel a subscription
     *
     * @param CancelSubscriptionRequest $cancelSubscriptionRequest
     * @param callable $callback = null (optional)
     * @return Models\Responses\CancelSubscription
     * @throws Exceptions\ExpiredAccessTokenException
     * @throws Exceptions\InvalidPackageNameException
     * @throws Exceptions\InvalidTokenException
     * @throws Exceptions\NetworkErrorException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\InvalidJsonException
     */
    public function cancelSubscription(CancelSubscriptionRequest $cancelSubscriptionRequest, \Closure $callback = null) {

        $this->prepare($cancelSubscriptionRequest);
        $this->checkToken();

        $bazaarApiClient = new BazaarApiClient();
        $bazaarApiClient->setClient($this->client);
        $bazaarApiClient->setRequest($cancelSubscriptionRequest);

        $requestOptions = $this->getRequestOptionsForGet();

        $bazaarApiClient->setRequestOptions($requestOptions);

        $cancelSubscription = $bazaarApiClient->request();

        if ($callback != null) {
            $callback($cancelSubscription);
        }

        return $cancelSubscription;


    }


    /**
     * get subscription status
     *
     * @param SubscriptionStatusRequest $subscriptionStatusRequest
     * @param callable $callback = null (optional)
     * @return Models\Responses\Subscription
     * @throws Exceptions\ExpiredAccessTokenException
     * @throws Exceptions\InvalidPackageNameException
     * @throws Exceptions\InvalidTokenException
     * @throws Exceptions\NetworkErrorException
     * @throws Exceptions\NotFoundException
     * @throws Exceptions\InvalidJsonException
     */
    public function getSubscription(SubscriptionStatusRequest $subscriptionStatusRequest, \Closure $callback = null) {

        $this->prepare($subscriptionStatusRequest);
        $this->checkToken();

        $bazaarApiClient = new BazaarApiClient();
        $bazaarApiClient->setClient($this->client);
        $bazaarApiClient->setRequest($subscriptionStatusRequest);

        $requestOptions = $this->getRequestOptionsForGet();

        $bazaarApiClient->setRequestOptions($requestOptions);

        $subscription = $bazaarApiClient->request();

        if ($callback != null) {
            $callback($subscription);
        }

        return $subscription;
    }


    /**
     * refresh access token
     *
     * @param RefreshTokenRequest $refreshTokenRequest
     * @param callable $callback
     * @return Models\Responses\RefreshToken
     * @throws Exceptions\NetworkErrorException
     * @throws Exceptions\InvalidJsonException
     */
    public function refreshToken(RefreshTokenRequest $refreshTokenRequest, \Closure $callback = null) {

        $this->prepare($refreshTokenRequest);

        $bazaarApiClient = new BazaarApiClient();
        $bazaarApiClient->setClient($this->client);
        $bazaarApiClient->setRequest($refreshTokenRequest);

        $requestOptions = $this->getRequestOptionsForPost($refreshTokenRequest->getPostData());

        $bazaarApiClient->setRequestOptions($requestOptions);

        $refreshToken = $bazaarApiClient->request();

        if ($callback != null) {
            $callback($refreshToken);
        }

        return $refreshToken;

    }


    /**
     * prepare for requesting
     *
     * @param BazaarApiRequest $request
     */
    protected function prepare(BazaarApiRequest $request) {

        if (!$this->client) {
            $this->client = new Client([
                'base_url' => $this->apiConfig->getBaseUrl()
            ]);
        }

        if (!$request->getApiConfig()) {
            $request->setApiConfig($this->apiConfig);

        }

        if (!$request->getAccountConfig()) {
            $request->setAccountConfig($this->getAccountConfig());

        }

    }

    /**
     * check token before api requesting
     */
    protected function checkToken() {

        if ($this->tokenManager->isTokenExpired()) {
            $refreshTokenRequest = new RefreshTokenRequest();

            $this->refreshToken($refreshTokenRequest, function (RefreshToken $refreshToken) {

                $this->tokenManager->storeToken($refreshToken->getAccessToken(), $refreshToken->getExpireIn());

            });
        }
    }

    /**
     * get options for GET requests
     *
     * @return array
     */
    protected function getRequestOptionsForGet() {
        return [
            'query'  => [
                'access_token' => $this->getTokenManager()->loadToken()
            ],
            'verify' => $this->getApiConfig()->isVerifySsl()
        ];
    }

    /**
     * get options for POST requests
     *
     * @param array $postData
     * @return array
     */
    protected function getRequestOptionsForPost($postData) {
        return [
            'body'   => $postData,
            'verify' => $this->getApiConfig()->isVerifySsl()
        ];
    }


}