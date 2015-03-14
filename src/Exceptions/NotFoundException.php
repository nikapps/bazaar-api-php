<?php namespace Nikapps\BazaarApiPhp\Exceptions;

class NotFoundException extends BazaarApiException{

    //{} empty json
    protected $message = 'Purchase or Subscription is not found';
} 