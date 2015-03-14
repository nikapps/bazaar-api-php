<?php namespace Nikapps\BazaarApiPhp\Exceptions;

class ExpiredAccessTokenException extends BazaarApiException {

    protected $message = 'Access token has been expired';
} 