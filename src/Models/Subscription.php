<?php
namespace Nikapps\BazaarApi\Models;

class Subscription extends Model
{

    protected $kind;
    protected $startTime;
    protected $endTime;
    protected $autoRenewing;

    protected function parse()
    {
        $response = $this->response;

        $this->kind = $response['kind'];
        $this->startTime = $response['initiationTimestampMsec'];
        $this->endTime = $response['validUntilTimestampMsec'];
        $this->autoRenewing = $response['autoRenewing'];
    }

    public function kind()
    {
        return $this->kind;
    }

    public function startTime()
    {
        return $this->startTime;
    }

    public function endTime()
    {
        return $this->endTime;
    }

    public function initiationTime()
    {
        return $this->startTime();
    }

    public function expirationTime()
    {
        return $this->endTime();
    }

    public function nextTime()
    {
        return $this->expirationTime();
    }

    public function expired()
    {
        $now = time() * 1000; // convert to ms

        return $now > $this->endTime;
    }

    public function autoRenewing()
    {
        return $this->autoRenewing;
    }

    public function found()
    {
        if (!$this->hasError()) {
            return true;
        }

        return false;
    }

    public function notFound()
    {
        return $this->failed() && $this->error == 'not_found';
    }

}