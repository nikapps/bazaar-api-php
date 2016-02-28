<?php
namespace Nikapps\BazaarApi\Models;

class Unsubscribe extends Model
{

    /**
     * unsubscribe was successful?
     *
     * @var bool
     */
    protected $successful = false;

    /**
     * {@inheritdoc}
     */
    protected function parse()
    {
        $this->successful = empty($this->response);
    }

    /**
     * @return bool
     */
    public function successful()
    {
        return $this->successful;
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
     * Subscription is not found?
     *
     * @return bool
     */
    public function notFound()
    {
        return $this->failed() && $this->error == 'not_found';
    }
}