<?php
namespace Nikapps\BazaarApi\Models;

class Unsubscribe extends Model
{

    protected $successful = false;

    protected function parse()
    {
        $this->successful = empty($this->response);
    }

    public function successful()
    {
        return $this->successful;
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