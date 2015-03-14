<?php namespace Nikapps\BazaarApiPhp\Models\Responses;

class RefreshToken extends BazaarApiResponse {

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @var string
     */
    protected $tokenType;

    /**
     * @var int
     */
    protected $expireIn;

    /**
     * @var string
     */
    protected $scope;

    /**
     * @return string
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken) {
        $this->accessToken = $accessToken;
    }

    /**
     * @return int
     */
    public function getExpireIn() {
        return $this->expireIn;
    }

    /**
     * @param int $expireIn
     */
    public function setExpireIn($expireIn) {
        $this->expireIn = $expireIn;
    }

    /**
     * @return string
     */
    public function getScope() {
        return $this->scope;
    }

    /**
     * @param string $scope
     */
    public function setScope($scope) {
        $this->scope = $scope;
    }

    /**
     * @return string
     */
    public function getTokenType() {
        return $this->tokenType;
    }

    /**
     * @param string $tokenType
     */
    public function setTokenType($tokenType) {
        $this->tokenType = $tokenType;
    }



} 