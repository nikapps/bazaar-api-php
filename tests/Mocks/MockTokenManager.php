<?php namespace Nikapps\BazaarApiPhpTests\Mocks;

use Nikapps\BazaarApiPhp\TokenManagers\TokenManagerInterface;

class MockTokenManager implements TokenManagerInterface{

    protected $accessToken = 'test';
    protected $isExpired = false;

    /**
     * when access token is received from CafeBazaar, this method will be called.
     *
     * @param string $accessToken access-token
     * @param int $ttl number of seconds remaining until the token expires
     * @return mixed
     */
    public function storeToken($accessToken, $ttl) {
        $this->accessToken = $accessToken;
    }

    /**
     * when access token is needed, this method will be called.
     *
     * @return string
     */
    public function loadToken() {
        return $this->accessToken;
    }

    /**
     * should we refresh token? (based on ttl)
     *
     * @return bool
     */
    public function isTokenExpired() {
        return $this->isExpired;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }

    /**
     * @param boolean $isExpired
     */
    public function setIsExpired($isExpired) {
        $this->isExpired = $isExpired;
    }




} 