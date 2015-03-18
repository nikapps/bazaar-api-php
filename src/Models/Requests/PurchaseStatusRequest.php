<?php namespace Nikapps\BazaarApiPhp\Models\Requests;

use Nikapps\BazaarApiPhp\Handlers\BazaarResponseHandlerInterface;
use Nikapps\BazaarApiPhp\Handlers\PurchaseHandler;

class PurchaseStatusRequest extends BazaarApiRequest {

    /**
     * package name
     *
     * @var string
     */
    protected $package;

    /**
     * product id in cafebazaar
     *
     * @var string
     */
    protected $productId;

    /**
     * purchase token
     *
     * @var string
     */
    protected $purchaseToken;

    function __construct($package = null, $productId = null, $purchaseToken = null) {
        $this->package = $package;
        $this->productId = $productId;
        $this->purchaseToken = $purchaseToken;
    }

    /**
     * get request uri
     *
     * @return string
     */
    public function getUri() {

        $uri = $this->getApiConfig()->getPurchasePath();

        $toReplace = [
            '{package}'         => $this->getPackage(),
            '{product_id}' => $this->getProductId(),
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
    public function getProductId() {
        return $this->productId;
    }

    /**
     * @param string $productId
     * @return $this
     */
    public function setProductId($productId) {
        $this->productId = $productId;

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
        return new PurchaseHandler();
    }


}