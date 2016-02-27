<?php
namespace Nikapps\BazaarApi\Models;

class Token extends Model
{

    protected $accessToken;
    protected $type;
    protected $lifetime;
    protected $refreshToken;
    protected $scope;

    protected function parse()
    {
        $response = $this->response;

        $this->accessToken = $response['access_token'];
        $this->type = $response['token_type'];
        $this->lifetime = $response['expires_in'];
        $this->refreshToken = $response['refresh_token'];
        $this->scope = $response['scope'];
    }

    public function accessToken()
    {
        return $this->accessToken;
    }

    public function refreshToken()
    {
        return $this->refreshToken;
    }

    public function type()
    {
        return $this->type;
    }

    public function lifetime()
    {
        return $this->lifetime;
    }

    public function expiresIn()
    {
        return $this->lifetime();
    }

    public function scope()
    {
        return $this->scope;
    }

}