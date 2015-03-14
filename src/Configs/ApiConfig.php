<?php namespace Nikapps\BazaarApiPhp\Configs;

class ApiConfig {

    /*
    |--------------------------------------------------------------------------
    | Cafebazaar Api Options
    |--------------------------------------------------------------------------
    | you change default options of api including path, base url, etc.
    |
    */

    /**
     * base url of cafebazaar api
     * @var string
     */
    protected $baseUrl = 'https://pardakht.cafebazaar.ir';

    /**
     * should we verify ssl certificate?
     * @var bool
     */
    protected $verifySsl = false;

    /**
     * authorization path for fetching refresh-token
     * @var string
     */
    protected $authorizationPath = '/auth/token/';

    /**
     * authorization grant type
     * @var string
     */
    protected $authorizationGrantType = 'authorization_code';

    /**
     * refresh access token path
     * @var string
     */
    protected $refreshTokenPath = '/auth/token/';

    /**
     * refresh token grant type
     * @var string
     */
    protected $refreshTokenGrantType = 'refresh_token';

    /**
     * purchase status path
     * @var string
     */
    protected $purchasePath = '/api/validate/{package}/inapp/{product_id}/purchases/{purchase_token}/?';

    /**
     * subscription status path
     * @var string
     */
    protected $subscriptionPath = '/api/applications/{package}/subscriptions/{subscription_id}/purchases/{purchase_token}/';

    /**
     * cancel a subscription path
     * @var string
     */
    protected $cancelSubscriptionPath = '/api/applications/{package}/subscriptions/{subscription_id}/purchases/{purchase_token}/cancel/';

    /**
     * @return string
     */
    public function getAuthorizationGrantType() {
        return $this->authorizationGrantType;
    }

    /**
     * @param string $authorizationGrantType
     * @return $this
     */
    public function setAuthorizationGrantType($authorizationGrantType) {
        $this->authorizationGrantType = $authorizationGrantType;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorizationPath() {
        return $this->authorizationPath;
    }

    /**
     * @param string $authorizationPath
     * @return $this
     */
    public function setAuthorizationPath($authorizationPath) {
        $this->authorizationPath = $authorizationPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl($baseUrl) {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getCancelSubscriptionPath() {
        return $this->cancelSubscriptionPath;
    }

    /**
     * @param string $cancelSubscriptionPath
     * @return $this
     */
    public function setCancelSubscriptionPath($cancelSubscriptionPath) {
        $this->cancelSubscriptionPath = $cancelSubscriptionPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getPurchasePath() {
        return $this->purchasePath;
    }

    /**
     * @param string $purchasePath
     * @return $this
     */
    public function setPurchasePath($purchasePath) {
        $this->purchasePath = $purchasePath;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefreshTokenGrantType() {
        return $this->refreshTokenGrantType;
    }

    /**
     * @param string $refreshTokenGrantType
     * @return $this
     */
    public function setRefreshTokenGrantType($refreshTokenGrantType) {
        $this->refreshTokenGrantType = $refreshTokenGrantType;

        return $this;
    }

    /**
     * @return string
     */
    public function getRefreshTokenPath() {
        return $this->refreshTokenPath;
    }

    /**
     * @param string $refreshTokenPath
     * @return $this
     */
    public function setRefreshTokenPath($refreshTokenPath) {
        $this->refreshTokenPath = $refreshTokenPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubscriptionPath() {
        return $this->subscriptionPath;
    }

    /**
     * @param string $subscriptionPath
     * @return $this
     */
    public function setSubscriptionPath($subscriptionPath) {
        $this->subscriptionPath = $subscriptionPath;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isVerifySsl() {
        return $this->verifySsl;
    }

    /**
     * @param boolean $verifySsl
     * @return $this
     */
    public function setVerifySsl($verifySsl) {
        $this->verifySsl = $verifySsl;

        return $this;
    }



} 