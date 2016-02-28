<?php
namespace Nikapps\BazaarApi\Models;

class Purchase extends Model
{
    /**
     * Is product consumed?
     *
     * @var bool
     */
    protected $consumed;
    /**
     * Is purchased or refunded?
     *
     * @var bool
     */
    protected $purchased;
    /**
     * Kind
     *
     * @var string
     */
    protected $kind;
    /**
     * Developer payload
     *
     * @var string
     */
    protected $payload;
    /**
     * Purchase time
     *
     * @var int
     */
    protected $time;

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $response = $this->response;

        $this->consumed = $response['consumptionState'] == 0 ? true : false;
        $this->purchased = $response['purchaseState'] == 0 ? true : false;
        $this->kind = $response['kind'];
        $this->payload = $response['developerPayload'];
        $this->time = $response['purchaseTime'];
    }

    /**
     * Is product consumed?
     *
     * @return bool
     */
    public function consumed()
    {
        return $this->consumed;
    }

    /**
     * Is product purchased or refunded?
     *
     * @return bool
     */
    public function purchased()
    {
        return $this->purchased;
    }

    /**
     * Is purchase refunded?
     *
     * @return bool
     */
    public function refunded()
    {
        return !$this->purchased();
    }

    /**
     * Get developer payload
     *
     * @return string
     */
    public function payload()
    {
        return $this->payload;
    }

    /**
     * Get developer payload
     *
     * @return string
     */
    public function developerPayload()
    {
        return $this->payload();
    }

    /**
     * Get purchase time
     *
     * @return int
     */
    public function time()
    {
        return $this->time;
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
     * purchase is found?
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
     * purchase is not found?
     *
     * @return bool
     */
    public function notFound()
    {
        return $this->failed() && $this->error == 'not_found';
    }
}
