<?php namespace Nikapps\BazaarApiPhp\Models\Requests;

use Nikapps\BazaarApiPhp\Handlers\BazaarResponseHandlerInterface;
use Nikapps\BazaarApiPhp\Handlers\CancelSubscriptionHandler;

class CancelSubscriptionRequest extends BazaarApiRequest {

    /**
     * package name
     *
     * @var string
     */
    protected $package;

    /**
     * subscription id in cafebazaar
     *
     * @var string
     */
    protected $subscriptionId;

    /**
     * purchase token
     *
     * @var string
     */
    protected $purchaseToken;

    function __construct($package = null, $subscriptionId = null, $purchaseToken = null) {
        $this->package = $package;
        $this->subscriptionId = $subscriptionId;
        $this->purchaseToken = $purchaseToken;
    }

    /**
     * get request uri
     *
     * @return string
     */
    public function getUri() {

        $uri = $this->getApiConfig()->getCancelSubscriptionPath();

        $toReplace = [
            '{package}'         => $this->getPackage(),
            '{subscription_id}' => $this->getSubscriptionId(),
            '{purchase_token}'  => $this->getPurchaseToken()
        ];

        return strtr($uri, $toReplace);

    }

    /**
     * @return string
     */
    public function getPackage() {
        return $this->package;
    }

    /**
     * @param string $package
     * @return $this
     */
    public function setPackage($package) {
        $this->package = $package;

        return $this;
    }

    /**
     * @return string
     */
    public function getPurchaseToken() {
        return $this->purchaseToken;
    }

    /**
     * @param string $purchaseToken
     * @return $this
     */
    public function setPurchaseToken($purchaseToken) {
        $this->purchaseToken = $purchaseToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubscriptionId() {
        return $this->subscriptionId;
    }

    /**
     * @param string $subscriptionId
     * @return $this
     */
    public function setSubscriptionId($subscriptionId) {
        $this->subscriptionId = $subscriptionId;

        return $this;
    }

    /**
     * is it a post request?
     *
     * @return bool
     */
    public function isPost() {
        return false;
    }

    /**
     * return response handler
     *
     * @return BazaarResponseHandlerInterface
     */
    public function getResponseHandler() {
        return new CancelSubscriptionHandler();
    }


}