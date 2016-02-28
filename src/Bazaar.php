<?php
namespace Nikapps\BazaarApi;

use GuzzleHttp\Client;
use Nikapps\BazaarApi\Client\ClientInterface;
use Nikapps\BazaarApi\Client\GuzzleClient;
use Nikapps\BazaarApi\Models\Purchase;
use Nikapps\BazaarApi\Models\Subscription;
use Nikapps\BazaarApi\Models\Token;
use Nikapps\BazaarApi\Models\Unsubscribe;
use Nikapps\BazaarApi\Storage\TokenStorageInterface;

class Bazaar
{
    /**
     * Token storage
     *
     * @var TokenStorageInterface
     */
    protected $storage;
    /**
     * Client
     *
     * @var ClientInterface
     */
    protected $client;
    /**
     * Config
     *
     * @var Config
     */
    protected $config;

    /**
     * Bazaar constructor.
     * @param Config $config
     * @param ClientInterface $client
     */
    public function __construct(Config $config, ClientInterface $client = null)
    {
        $this->config = $config;
        $this->storage = $config->storage();
        $this->client = is_null($client)
            ? new GuzzleClient(new Client())
            : $client;
    }

    /**
     * Refresh token and get a new access token
     *
     * @return Token
     */
    public function refreshToken()
    {
        $response = $this->client->post($this->config->url('token'), [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'client_id' => $this->config->clientId(),
                'client_secret' => $this->config->clientSecret(),
                'refresh_token' => $this->config->refreshToken()
            ]
        ]);

        return new Token(array_merge(
            $response, ['refresh_token' => $this->config->refreshToken()]
        ));
    }

    /**
     * Fetch refresh token
     *
     * @param string $redirectUrl
     * @param array $input
     * @return Token
     * @throws bazaarException
     */
    public function token($redirectUrl, array $input = [])
    {
        $input = count($input) ? $input : $_GET;
        $this->guardAgainstEmptyCode($input);

        $code = trim($input['code']);

        $response = $this->client->post($this->config->url('token'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => $this->config->clientId(),
                'client_secret' => $this->config->clientSecret(),
                'code' => $code,
                'redirect_uri' => $redirectUrl
            ]
        ]);

        return new Token($response);
    }

    /**
     * Fetch state of a purchase
     *
     * @param string $package
     * @param string $id
     * @param string $purchaseToken
     * @return Purchase
     */
    public function purchase($package, $id, $purchaseToken)
    {
        $response = $this->client->get($this->makePurchaseUrl($package, $id, $purchaseToken), [
            'query' => [
                'access_token' => $this->fetchToken()
            ]
        ]);

        return new Purchase($response);
    }

    /**
     * Get state of a subscription
     *
     * @param string $package
     * @param string $id
     * @param string $purchaseToken
     * @return Subscription
     */
    public function subscription($package, $id, $purchaseToken)
    {
        $response = $this->client->get($this->makeSubscriptionUrl($package, $id, $purchaseToken), [
            'query' => [
                'access_token' => $this->fetchToken()
            ]
        ]);

        return new Subscription($response);
    }

    /**
     * Unsubscribe to a subscription (cancelling a subscription)
     *
     * @param string $package
     * @param string $id
     * @param string $purchaseToken
     * @return Unsubscribe
     */
    public function unsubscribe($package, $id, $purchaseToken)
    {
        $response = $this->client->get($this->makeUnsubscribeUrl($package, $id, $purchaseToken), [
            'query' => [
                'access_token' => $this->fetchToken()
            ]
        ]);

        return new Unsubscribe($response);
    }

    /**
     * Refresh token and store the new one
     *
     * @return Token
     * @throws BazaarException
     */
    public function refreshTokenAndStore()
    {
        $token = $this->refreshToken();
        if ($token->failed()) {
            throw new BazaarException("Cannot refresh token: " . $token->errorDescription());
        }

        $this->storage->save($token);

        return $token;
    }

    /**
     * Get config
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get client
     *
     * @return ClientInterface|GuzzleClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get storage
     *
     * @return TokenStorageInterface
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Check input has 'code' and it is not empty
     *
     * @param array $input
     * @throws bazaarException
     */
    protected function guardAgainstEmptyCode($input)
    {
        if (!isset($input['code']) || !trim($input['code'])) {
            throw new bazaarException('Code is not found');
        }
    }

    /**
     * Generate purchase endpoint url
     *
     * @param string $package
     * @param string $id
     * @param string $purchaseToken
     * @return string
     */
    protected function makePurchaseUrl($package, $id, $purchaseToken)
    {
        return strtr($this->config->url('purchase'),
            [
                ':package_name' => $package,
                ':purchase_id' => $id,
                ':purchase_token' => $purchaseToken
            ]
        );
    }

    /**
     * Generate subscription endpoint url
     *
     * @param string $package
     * @param string $id
     * @param string $purchaseToken
     * @return string
     */
    protected function makeSubscriptionUrl($package, $id, $purchaseToken)
    {
        return strtr($this->config->url('subscription'),
            [
                ':package_name' => $package,
                ':subscription_id' => $id,
                ':purchase_token' => $purchaseToken
            ]
        );
    }

    /**
     * Generate unsubscribe endpoint url
     *
     * @param string $package
     * @param string $id
     * @param string $purchaseToken
     * @return string
     */
    protected function makeUnsubscribeUrl($package, $id, $purchaseToken)
    {
        return strtr($this->config->url('unsubscribe'),
            [
                ':package_name' => $package,
                ':subscription_id' => $id,
                ':purchase_token' => $purchaseToken
            ]
        );
    }

    /**
     * Find token from storage or refresh token and get a new one if needed
     *
     * @return null|string
     * @throws BazaarException
     */
    protected function fetchToken()
    {
        if (!$this->storage->expired()) {
            return $this->storage->retrieve();
        }

        $token = $this->refreshTokenAndStore();

        return $token->accessToken();
    }
}
