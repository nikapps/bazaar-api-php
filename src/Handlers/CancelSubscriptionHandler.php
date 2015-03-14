<?php namespace Nikapps\BazaarApiPhp\Handlers;

use Nikapps\BazaarApiPhp\Models\Responses\BazaarApiResponse;
use Nikapps\BazaarApiPhp\Models\Responses\CancelSubscription;

class CancelSubscriptionHandler implements BazaarResponseHandlerInterface{

    /**
     * @var CancelSubscription
     */
    protected $cancelSubscription;

    /**
     * handle json response
     *
     * @param array $responseJson
     */
    public function handle($responseJson) {

        $this->cancelSubscription = new CancelSubscription();
        $this->cancelSubscription->setResponseJson($responseJson);

        if (!$responseJson || empty($responseJson)) {

            $this->cancelSubscription->setIsCancelled(true);
        }
    }

    /**
     * @return CancelSubscription
     */
    public function getResponseModel() {

        return $this->cancelSubscription;
    }


} 