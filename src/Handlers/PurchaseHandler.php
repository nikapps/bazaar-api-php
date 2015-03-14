<?php namespace Nikapps\BazaarApiPhp\Handlers;

use Nikapps\BazaarApiPhp\Exceptions\InvalidJsonException;
use Nikapps\BazaarApiPhp\Exceptions\NotFoundException;
use Nikapps\BazaarApiPhp\Models\Responses\Purchase;

class PurchaseHandler implements BazaarResponseHandlerInterface {

    /**
     * @var Purchase
     */
    protected $purchase;

    /**
     * handle json response
     *
     * @param array $responseJson
     * @throws NotFoundException
     * @throws InvalidJsonException
     */
    public function handle($responseJson) {

        $this->purchase = new Purchase();
        $this->purchase->setResponseJson($responseJson);

        $this->isJsonValid($responseJson);

        $this->purchase->setConsumptionState($responseJson['consumptionState']);
        $this->purchase->setPurchaseState($responseJson['purchaseState']);
        $this->purchase->setKind($responseJson['kind']);
        $this->purchase->setDeveloperPayload($responseJson['developerPayload']);
        $this->purchase->setPurchaseTime($responseJson['purchaseTime']);
    }

    /**
     * @return Purchase
     */
    public function getResponseModel() {

        return $this->purchase;
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
            'consumptionState',
            'purchaseState',
            'kind',
            'developerPayload',
            'purchaseTime'
        ];

        if (0 === count(array_diff($keysShouldExist, array_keys($responseJson)))) {
            return true;
        } else {
            throw new InvalidJsonException;
        }
    }


} 