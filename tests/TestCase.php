<?php namespace Nikapps\BazaarApiPhpTests;

use Nikapps\BazaarApiPhp\Configs\AccountConfig;
use Nikapps\BazaarApiPhp\Configs\ApiConfig;
use PHPUnit_Framework_TestCase;

class TestCase extends PHPUnit_Framework_TestCase{

    /** @var ApiConfig */
    protected $apiConfig;

    /** @var AccountConfig */
    protected $accountConfig;

    /**
     * @return AccountConfig
     */
    public function getAccountConfig() {

        if(!$this->accountConfig){
            $this->accountConfig = new AccountConfig();
        }

        return $this->accountConfig;
    }

    /**
     * @return ApiConfig
     */
    public function getApiConfig() {

        if(!$this->apiConfig){
            $this->apiConfig = new ApiConfig();
        }
        
        return $this->apiConfig;
    }

} 