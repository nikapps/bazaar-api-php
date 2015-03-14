<?php namespace Nikapps\BazaarApiPhp\Configs;

class AccountConfig {

    /*
    |--------------------------------------------------------------------------
    | Cafebazaar Credentials
    |--------------------------------------------------------------------------
    | you should set your cafebazaar credentials.
    | @see http://pardakht.cafebazaar.ir/doc/developer-api/?l=fa
    |
    */

    /**
     * your client id
     * @var string
     */
    protected $clientId = 'you_should_set_your_client_id';

    /**
     * your client secret
     * @var string
     */
    protected $clientSecret = 'you_should_set_your_client_secret';

    /**
     * redirect uri (only for fetching refresh token)
     * @var string
     */
    protected $redirectUri = 'you_should_set_your_redirect_uri';

    /**
     * your returned code
     *
     * <REDIRECT_URI>?code=<CODE>
     *
     * @var string
     */
    protected $code = 'you_should_set_your_returned_code';

    /**
     * your refresh token
     *
     * you can get your refresh token by
     *  $bazaarApi->fetchRefreshToken();
     *
     * @var string
     */
    protected $refreshToken = 'you_should_set_your_refresh_token';

    /**
     * @return string
     */
    public function getClientSecret() {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     * @return $this
     */
    public function setClientSecret($clientSecret) {
        $this->clientSecret = $clientSecret;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function setCode($code) {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getRedirectUri() {
        return $this->redirectUri;
    }

    /**
     * @param string $redirectUri
     * @return $this
     */
    public function setRedirectUri($redirectUri) {
        $this->redirectUri = $redirectUri;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefreshToken() {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     * @return $this
     */
    public function setRefreshToken($refreshToken) {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getClientId() {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return $this
     */
    public function setClientId($clientId) {
        $this->clientId = $clientId;

        return $this;
    }





} 