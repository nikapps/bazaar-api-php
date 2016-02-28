<?php
namespace Nikapps\BazaarApi\Models;

class Token extends Model
{

    /**
     * Access token
     *
     * @var string
     */
    protected $accessToken;
    /**
     * Token type
     *
     * @var string
     */
    protected $type;
    /**
     * Lifetime (expires in)
     *
     * @var int
     */
    protected $lifetime;
    /**
     * Refresh token
     *
     * @var string
     */
    protected $refreshToken;
    /**
     * Scope
     *
     * @var string
     */
    protected $scope;

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $response = $this->response;

        $this->accessToken = $response['access_token'];
        $this->type = $response['token_type'];
        $this->lifetime = $response['expires_in'];
        $this->refreshToken = $response['refresh_token'];
        $this->scope = $response['scope'];
    }

    /**
     * Get access token
     *
     * @return string
     */
    public function accessToken()
    {
        return $this->accessToken;
    }

    /**
     * Get refresh token
     *
     * @return string
     */
    public function refreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Get token type
     *
     * @return string
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Get token's lifetime
     *
     * @return int
     */
    public function lifetime()
    {
        return $this->lifetime;
    }

    /**
     * When token will be expired (lifetime)
     *
     * @return int
     */
    public function expiresIn()
    {
        return $this->lifetime();
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function scope()
    {
        return $this->scope;
    }

}