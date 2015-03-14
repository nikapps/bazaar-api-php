<?php namespace Nikapps\BazaarApiPhp\Models\Requests;

use Nikapps\BazaarApiPhp\Handlers\BazaarResponseHandlerInterface;
use Nikapps\BazaarApiPhp\Handlers\RefreshTokenHandler;

class RefreshTokenRequest extends BazaarApiRequest{

    /**
     * get request uri
     *
     * @return string
     */
    public function getUri() {
        return $this->getApiConfig()->getRefreshTokenPath();
    }

    /**
     * get post data
     *
     * @return array
     */
    public function getPostData() {
        return [
            'grant_type' => $this->getApiConfig()->getRefreshTokenGrantType(),
            'client_id' => $this->getAccountConfig()->getClientId(),
            'client_secret' => $this->getAccountConfig()->getClientSecret(),
            'refresh_token' => $this->getAccountConfig()->getRefreshToken()
        ];
    }

    /**
     * is it a post request?
     *
     * @return bool
     */
    public function isPost() {
        return true;
    }

    /**
     * return response handler
     *
     * @return BazaarResponseHandlerInterface
     */
    public function getResponseHandler() {
        return new RefreshTokenHandler();
    }


} 