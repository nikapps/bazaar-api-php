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
     * @var TokenStorageInterface
     */
    protected $storage;
    /**
     * @var ClientInterface
     */
    protected $client;
    /**
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

    public function purchase($package, $id, $purchaseToken)
    {
        $response = $this->client->get($this->makePurchaseUrl($package, $id, $purchaseToken), [
            'query' => [
                'access_token' => $this->fetchToken()
            ]
        ]);

        return new Purchase($response);
    }

    public function subscription($package, $id, $purchaseToken)
    {
        $response = $this->client->get($this->makeSubscriptionUrl($package, $id, $purchaseToken), [
            'query' => [
                'access_token' => $this->fetchToken()
            ]
        ]);

        return new Subscription($response);
    }

    public function unsubscribe($package, $id, $purchaseToken)
    {
        $response = $this->client->get($this->makeUnsubscribeUrl($package, $id, $purchaseToken), [
            'query' => [
                'access_token' => $this->fetchToken()
            ]
        ]);

        return new Unsubscribe($response);
    }

    public function refreshTokenAndStore()
    {
        $token = $this->refreshToken();
        if ($token->failed()) {
            throw new BazaarException("Cannot refresh token: " . $token->errorDescription());
        }

        $this->storage->save($token);

        return $token;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getStorage()
    {
        return $this->storage;
    }

    protected function guardAgainstEmptyCode($input)
    {
        if (!isset($input['code']) || !trim($input['code'])) {
            throw new bazaarException('Code is not found');
        }
    }

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

    protected function fetchToken()
    {
        if (!$this->storage->expired()) {
            return $this->storage->retrieve();
        }

        $token = $this->refreshTokenAndStore();

        return $token->accessToken();
    }

}