<?php
namespace Nikapps\BazaarApi\Models;

abstract class Model
{
    protected $response;
    protected $error;
    protected $errorDescription;


    /**
     * Purchase constructor.
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->response = $response;

        if ($this->hasError()) {
            $this->parseError();
        } else {
            $this->parse();
        }
    }

    protected function parseError()
    {
        $this->error = $this->response['error'];
        $this->errorDescription = isset($this->response['error_description'])
            ? $this->response['error_description']
            : $this->response['error'];
    }

    abstract protected function parse();

    public function hasError()
    {
        return isset($this->response['error']);
    }

    public function response()
    {
        return $this->response;
    }

    public function failed()
    {
        return $this->hasError();
    }

    public function error()
    {
        return $this->error;
    }

    public function errorDescription()
    {
        return $this->errorDescription;
    }
}