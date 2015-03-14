<?php namespace Nikapps\BazaarApiPhp\Models\Requests;

use Nikapps\BazaarApiPhp\Handlers\BazaarResponseHandlerInterface;
use Nikapps\BazaarApiPhp\Handlers\FetchRefreshTokenHandler;

class AuthorizationRequest extends BazaarApiRequest {

    /**
     * get request uri
     *
     * @return string
     */
    public function getUri() {
        return $this->getApiConfig()->getAuthorizationPath();
    }

    /**
     * get post data
     *
     * @override
     * @return array
     */
    public function getPostData() {
        return [
            'grant_type' => $this->getApiConfig()->getAuthorizationGrantType(),
            'code' => $this->getAccountConfig()->getCode(),
            'client_id' => $this->getAccountConfig()->getClientId(),
            'client_secret' => $this->getAccountConfig()->getClientSecret(),
            'redirect_uri' => $this->getAccountConfig()->getRedirectUri()
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
        return new FetchRefreshTokenHandler();
    }


} 