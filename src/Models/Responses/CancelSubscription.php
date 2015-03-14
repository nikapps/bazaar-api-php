<?php namespace Nikapps\BazaarApiPhp\Models\Responses;

class CancelSubscription extends BazaarApiResponse {

    /**
     * @var bool
     */
    protected $isCancelled = false;

    /**
     * @return boolean
     */
    public function isCancelled() {
        return $this->isCancelled;
    }

    /**
     * @param boolean $isCancelled
     */
    public function setIsCancelled($isCancelled) {
        $this->isCancelled = $isCancelled;
    }


} 