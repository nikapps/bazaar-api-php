<?php namespace Nikapps\BazaarApiPhp\Models\Responses;

use Carbon\Carbon;

class Subscription extends BazaarApiResponse {


    /**
     * @var Carbon
     */
    private $initiationTime;

    /**
     * @var Carbon
     */
    private $expirationTime;

    /**
     * @var string
     */
    private $kind;

    /**
     * @var boolean
     */
    private $autoRenewing;


    /**
     * @return boolean
     */
    public function isAutoRenewing() {
        return $this->autoRenewing;
    }

    /**
     * @param boolean $autoRenewing
     */
    public function setAutoRenewing($autoRenewing) {
        $this->autoRenewing = $autoRenewing;
    }

    /**
     * @return Carbon
     */
    public function getExpirationTime() {
        return $this->expirationTime;
    }

    /**
     * @param int $expirationTime
     */
    public function setExpirationTime($expirationTime) {
        $inSeconds = intval($expirationTime/1000);
        $this->expirationTime = Carbon::createFromTimestampUTC($inSeconds);
    }

    /**
     * @return Carbon
     */
    public function getInitiationTime() {
        return $this->initiationTime;
    }

    /**
     * @param int $initiationTime
     */
    public function setInitiationTime($initiationTime) {
        $inSeconds = intval($initiationTime/1000);
        $this->initiationTime = Carbon::createFromTimestampUTC($inSeconds);
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


} 