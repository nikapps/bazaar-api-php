<?php namespace Nikapps\BazaarApiPhp\Handlers;

use Nikapps\BazaarApiPhp\Exceptions\InvalidJsonException;
use Nikapps\BazaarApiPhp\Exceptions\NotFoundException;
use Nikapps\BazaarApiPhp\Models\Responses\BazaarApiResponse;
use Nikapps\BazaarApiPhp\Models\Responses\Subscription;

class SubscriptionHandler implements BazaarResponseHandlerInterface {

    /**
     * @var Subscription
     */
    protected $subscription;

    /**
     * handle json response
     *
     * @param array $responseJson
     * @throws NotFoundException
     * @throws InvalidJsonException
     */
    public function handle($responseJson) {

        $this->subscription = new Subscription();
        $this->subscription->setResponseJson($responseJson);

        $this->isJsonValid($responseJson);

        $this->subscription->setKind($responseJson['kind']);
        $this->subscription->setInitiationTime($responseJson['initiationTimestampMsec']);
        $this->subscription->setExpirationTime($responseJson['validUntilTimestampMsec']);
        $this->subscription->setAutoRenewing($responseJson['autoRenewing']);

    }

    /**
     * @return Subscription
     */
    public function getResponseModel() {

        return $this->subscription;
    }

    /**
     * check json is valid or not
     *
     * @param $responseJson
     * @throws InvalidJsonException
     * @throws NotFoundException
     * @return bool
     */
    protected function isJsonValid($responseJson) {

        if (!$responseJson || empty($responseJson)) {
            throw new NotFoundException;
        }

        $keysShouldExist = [
            'kind',
            'initiationTimestampMsec',
            'validUntilTimestampMsec',
            'autoRenewing'
        ];

        if (0 === count(array_diff($keysShouldExist, array_keys($responseJson)))) {
            return true;
        } else {
            throw new InvalidJsonException;
        }
    }


} 