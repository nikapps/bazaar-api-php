<?php namespace Nikapps\BazaarApiPhp\Models\Responses;

use Carbon\Carbon;

class Purchase extends BazaarApiResponse {

    /**
     * purchase status flags
     */
    const PURCHASE_STATUS_PURCHASED = 0;
    const PURCHASE_STATUS_CANCELLED = 1;
    const PURCHASE_STATUS_REFUNDED = 2;

    /**
     * consumption status flags
     */
    const CONSUMPTION_STATUS_NOT_CONSUMED = 1;
    const CONSUMPTION_STATUS_CONSUMED = 0;


    /**
     * @var int
     */
    private $consumptionState;

    /**
     * @var int
     */
    private $purchaseState;

    /**
     * @var string
     */
    private $kind;

    /**
     * @var string
     */
    private $developerPayload;

    /**
     * @var Carbon
     */
    private $purchaseTime;

    /**
     * @return int
     */
    public function getConsumptionState() {
        return $this->consumptionState;
    }

    /**
     * @param int $consumptionState
     */
    public function setConsumptionState($consumptionState) {
        $this->consumptionState = $consumptionState;
    }

    /**
     * @return string
     */
    public function getDeveloperPayload() {
        return $this->developerPayload;
    }

    /**
     * @param string $developerPayload
     */
    public function setDeveloperPayload($developerPayload) {
        $this->developerPayload = $developerPayload;
    }

    /**
     * @return string
     */
    public function getKind() {
        return $this->kind;
    }

    /**
     * @param string $kind
     */
    public function setKind($kind) {
        $this->kind = $kind;
    }

    /**
     * @return int
     */
    public function getPurchaseState() {
        return $this->purchaseState;
    }

    /**
     * @param int $purchaseState
     */
    public function setPurchaseState($purchaseState) {
        $this->purchaseState = $purchaseState;
    }

    /**
     * @return Carbon
     */
    public function getPurchaseTime() {
        return $this->purchaseTime;
    }

    /**
     * @param int $purchaseTime
     */
    public function setPurchaseTime($purchaseTime) {
        $inSeconds = intval($purchaseTime/1000);
        $this->purchaseTime = Carbon::createFromTimestampUTC($inSeconds);
    }


} 