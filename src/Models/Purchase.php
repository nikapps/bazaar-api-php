<?php
namespace Nikapps\BazaarApi\Models;

class Purchase extends Model
{
    protected $consumed;
    protected $purchased;
    protected $kind;
    protected $payload;
    protected $time;

    protected function parse()
    {
        $response = $this->response;

        $this->consumed = $response['consumptionState'] == 0 ? true : false;
        $this->purchased = $response['purchaseState'] == 0 ? true : false;
        $this->kind = $response['kind'];
        $this->payload = $response['developerPayload'];
        $this->time = $response['purchaseTime'];
    }

    public function consumed()
    {
        return $this->consumed;
    }

    public function purchased()
    {
        return $this->purchased;
    }

    public function refunded()
    {
        return !$this->purchased();
    }

    public function payload()
    {
        return $this->payload;
    }

    public function developerPayload()
    {
        return $this->payload();
    }

    public function time()
    {
        return $this->time;
    }

    public function kind()
    {
        return $this->kind;
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