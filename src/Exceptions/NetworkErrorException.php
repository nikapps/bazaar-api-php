<?php namespace Nikapps\BazaarApiPhp\Exceptions;

use GuzzleHttp\Exception\ClientException;

class NetworkErrorException extends BazaarApiException{

    protected $message = "Error in network";

    /**
     * @var ClientException
     */
    protected $clientException;

    /**
     * @return ClientException
     */
    public function getClientException() {
        return $this->clientException;
    }

    /**
     * @param ClientException $clientException
     */
    public function setClientException($clientException) {
        $this->clientException = $clientException;
    }



} 