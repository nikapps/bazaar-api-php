<?php namespace Nikapps\BazaarApiPhp\Models\Requests;

use Nikapps\BazaarApiPhp\Configs\AccountConfig;
use Nikapps\BazaarApiPhp\Configs\ApiConfig;
use Nikapps\BazaarApiPhp\Handlers\BazaarResponseHandlerInterface;

abstract class BazaarApiRequest {

    /**
     * @var AccountConfig
     */
    private $accountConfig;

    /**
     * @var ApiConfig
     */
    private $apiConfig;

    /**
     * @return AccountConfig
     */
    public function getAccountConfig() {
        return $this->accountConfig;
    }

    /**
     * @return ApiConfig
     */
    public function getApiConfig() {
        return $this->apiConfig;
    }

    /**
     * @param AccountConfig $accountConfig
     */
    public function setAccountConfig($accountConfig) {
        $this->accountConfig = $accountConfig;
    }

    /**
     * @param ApiConfig $apiConfig
     */
    public function setApiConfig($apiConfig) {
        $this->apiConfig = $apiConfig;
    }


    /**
     * get post data as array
     *
     * @return array
     */
    public function getPostData(){
        return [];
    }

    /**
     * get request uri
     *
     * @return string
     */
    abstract public function getUri();

    /**
     * is it a post request?
     *
     * @return bool
     */
    abstract public function isPost();

    /**
     * return response handler
     *
     * @return BazaarResponseHandlerInterface
     */
    abstract public function getResponseHandler();



} 