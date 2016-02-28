<?php
namespace Nikapps\BazaarApi\Models;

class Subscription extends Model
{

    /**
     * Kind
     *
     * @var string
     */
    protected $kind;
    /**
     * start time of subscription (timestamp in ms)
     *
     * @var int
     */
    protected $startTime;
    /**
     * end time of subscription (timestamp in ms)
     *
     * @var int
     */
    protected $endTime;
    /**
     * Is subscription auto renewing?
     *
     * @var bool
     */
    protected $autoRenewing;


    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $response = $this->response;

        $this->kind = $response['kind'];
        $this->startTime = $response['initiationTimestampMsec'];
        $this->endTime = $response['validUntilTimestampMsec'];
        $this->autoRenewing = $response['autoRenewing'];
    }

    /**
     * Get kind
     *
     * @return string
     */
    public function kind()
    {
        return $this->kind;
    }

    /**
     * Get start time of subscription (timestamp in ms)
     *
     * @return int
     */
    public function startTime()
    {
        return $this->startTime;
    }

    /**
     * Get end time of subscription (timestamp in ms)
     *
     * @return int
     */
    public function endTime()
    {
        return $this->endTime;
    }

    /**
     * Get initiation time of subscription (start time)
     *
     * @return int
     */
    public function initiationTime()
    {
        return $this->startTime();
    }

    /**
     * Get expiration time of subscription (end time)
     *
     * @return int
     */
    public function expirationTime()
    {
        return $this->endTime();
    }

    /**
     * When subscription will be renewed (end time)
     *
     * Only if autoRenewing equals true
     *
     * @return int
     */
    public function nextTime()
    {
        return $this->expirationTime();
    }

    /**
     * Is subscription expired?
     *
     * @return bool
     */
    public function expired()
    {
        $now = time() * 1000; // convert to ms

        return $now > $this->endTime;
    }

    /**
     * Is subscription automatically renewed?
     *
     * @return bool
     */
    public function autoRenewing()
    {
        return $this->autoRenewing;
    }

    /**
     * subscription is found?
     *
     * @return bool
     */
    public function found()
    {
        if (!$this->hasError()) {
            return true;
        }

        return false;
    }

    /**
     * subscription is not found?
     *
     * @return bool
     */
    public function notFound()
    {
        return $this->failed() && $this->error == 'not_found';
    }
}
