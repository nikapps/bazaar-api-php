<?php namespace Nikapps\BazaarApiPhp\TokenManagers;

use Carbon\Carbon;

class FileTokenManager implements TokenManagerInterface {

    protected $path = '';

    /**
     * @return string
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path) {
        $this->path = $path;
    }


    /**
     * when access token is received from CafeBazaar, this method will be called.
     *
     * @param string $accessToken access-token
     * @param int $ttl number of seconds remaining until the token expires
     * @return mixed
     */
    public function storeToken($accessToken, $ttl) {
        $storeTime = Carbon::now();
        $token = [
            'access_token' => $accessToken,
            'ttl'          => $ttl,
            'stored_at'    => $storeTime->timestamp
        ];

        file_put_contents($this->getPath(), json_encode($token));
    }

    /**
     * when access token is needed, this method will be called.
     *
     * @return string
     */
    public function loadToken() {
        $tokenJson = file_get_contents($this->getPath());

        $token = json_decode($tokenJson);

        if (isset($token['access_token'])) {
            return $token['access_token'];
        } else {
            return '';
        }
    }

    /**
     * should we refresh token? (based on ttl)
     *
     * @return bool
     */
    public function isTokenExpired() {
        $tokenJson = file_get_contents($this->getPath());

        $token = json_decode($tokenJson);

        if (isset($token['access_token'], $token['ttl'], $token['stored_at'])) {
            $ttl = $token['ttl'];
            $storeTime = Carbon::createFromTimestamp($token['stored_at']);

            if ($storeTime->diffInSeconds() >= $ttl) {
                return true;
            } else {
                return false;
            }

        } else {
            return true;
        }

    }


} 
