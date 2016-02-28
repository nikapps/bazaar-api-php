<?php
namespace Nikapps\BazaarApi\Models;

abstract class Model
{
    /**
     * Response
     *
     * @var array
     */
    protected $response;
    /**
     * Error code
     *
     * @var string
     */
    protected $error;
    /**
     * Error description
     *
     * @var string
     */
    protected $errorDescription;


    /**
     * Model constructor.
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

    /**
     * Parse error keys from response
     */
    protected function parseError()
    {
        $this->error = $this->response['error'];
        $this->errorDescription = isset($this->response['error_description'])
            ? $this->response['error_description']
            : $this->response['error'];
    }

    /**
     * Parse successful response
     */
    abstract protected function parse();

    /**
     * Response has error?
     *
     * @return bool
     */
    public function hasError()
    {
        return isset($this->response['error']);
    }

    /**
     * Get response
     *
     * @return array
     */
    public function response()
    {
        return $this->response;
    }

    /**
     * Is request failed?
     *
     * @return bool
     */
    public function failed()
    {
        return $this->hasError();
    }

    /**
     * Get error code
     *
     * @return string
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Get error description
     *
     * @return string
     */
    public function errorDescription()
    {
        return $this->errorDescription;
    }
}
