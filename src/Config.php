<?php
namespace Nikapps\BazaarApi;

use Nikapps\BazaarApi\Storage\MemoryTokenStorage;
use Nikapps\BazaarApi\Storage\TokenStorageInterface;

class Config
{
    protected $options;

    /**
     * Config constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $default = [
            'client-id' => 'set-your-client-id',
            'client-secret' => 'set-your-client-secret',
            'refresh-token' => 'your-refresh-token',
            'storage' => new MemoryTokenStorage(),
            'purchase-url' => 'https://pardakht.cafebazaar.ir/devapi/v2/api/validate/:package_name/inapp/:purchase_id/purchases/:purchase_token/',
            'subscription-url' => 'https://pardakht.cafebazaar.ir/devapi/v2/api/applications/:package_name/subscriptions/:subscription_id/purchases/:purchase_token/',
            'unsubscribe-url' => 'https://pardakht.cafebazaar.ir/devapi/v2/api/applications/:package_name/subscriptions/:subscription_id/purchases/:purchase_token/cancel/',
            'token-url' => 'https://pardakht.cafebazaar.ir/devapi/v2/auth/token/'
        ];

        $this->options = array_merge($default, $options);
    }

    public function url($endpoint)
    {
        return $this->options["$endpoint-url"];
    }

    public function clientSecret()
    {
        return $this->options['client-secret'];
    }

    public function clientId()
    {
        return $this->options['client-id'];
    }

    public function storage()
    {
        return $this->options['storage'];
    }

    public function setStorage(TokenStorageInterface $storage)
    {
        $this->options['storage'] = $storage;
    }

    public function refreshToken()
    {
        return $this->options['refresh-token'];
    }

}