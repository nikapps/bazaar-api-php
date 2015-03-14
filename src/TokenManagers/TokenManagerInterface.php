<?php namespace Nikapps\BazaarApiPhp\TokenManagers;

interface TokenManagerInterface {

    /**
     * when access token is received from CafeBazaar, this method will be called.
     *
     * @param string $accessToken access-token
     * @param int $ttl number of seconds remaining until the token expires
     * @return mixed
     */
    public function storeToken($accessToken, $ttl);

    /**
     * when access token is needed, this method will be called.
     *
     * @return string
     */
    public function loadToken();

    /**
     * should we refresh token? (based on ttl)
     *
     * @return bool
     */
    public function isTokenExpired();
} 