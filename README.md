# Bazaar-Api-PHP (BazaarApi for PHP)

A PHP API wrapper for [Cafebazaar REST API (v2)](https://cafebazaar.ir/developers/docs/developer-api/v2/introduction/?l=fa).

**If you are looking for version 1.x, please go to [branch v1](https://github.com/nikapps/bazaar-api-php/tree/v1/).**

![CafeBazaar Logo](https://dl.dropboxusercontent.com/u/29141199/bazaar-logo-and-logotype.png?raw=1)

## Table of Contents
- [Bazaar-Api-PHP (BazaarApi for PHP)](#bazaar-api-php-bazaarapi-for-php)
    - [Table of Contents](#table-of-contents)
    - [Installation](#installation)
    - [Configuration](#configuration)
        - [Create a client](#create-a-client)
        - [Getting refresh token](#getting-refresh-token)
        - [Setting up config](#setting-up-config)
    - [Usage](#usage)
        - [Purchase](#purchase)
        - [Subscription](#subscription)
        - [Cancel Subscription (Unsubscribe)](#cancel-subscription-unsubscribe)
    - [Customization](#customization)
        - [Custom Token Storage](#custom-token-storage)
    - [Examples](#examples)
    - [Dependencies](#dependencies)
    - [Testing](#testing)
    - [Official Documentation](#official-documentation)
    - [Contribute](#contribute)
    - [License](#license)
    - [Donation](#donation)


## Installation

If you don't have [Composer](https://getcomposer.org), first you should install it on your system:

```
https://getcomposer.org

```

Now run this command to install [the package](https://packagist.org/packages/nikapps/bazaar-api-php):

```
composer require nikapps/bazaar-api-php
```

* **Notice:** if you don't know anything about **composer**, please read this [article](https://scotch.io/tutorials/a-beginners-guide-to-composer). 


## Configuration

### Create a client

First, you should go to your cafebazaar panel and create a client.

* Login to your panel and go to this url:
`https://pardakht.cafebazaar.ir/panel/developer-api/?l=fa&nd=False`

* Click on `new client` and enter your redirect uri (it is needed for getting returned `code` and `refresh_token`. see the [next section](#getting-refresh-token))

now you have your `client-id` and `client-secret`.


### Getting refresh token

* Open this url in your browser:

```
https://pardakht.cafebazaar.ir/devapi/v2/auth/authorize/?response_type=code&access_type=offline&redirect_uri=<REDIRECT_URI>&client_id=<CLIENT_ID>
```


**Don't forget to change `<REDIRECT_URI>` and `<CLIENT_ID>`.**

* After clicking on accept/confirm button, you will be redirected to: `<REDIRECT_URI>?code=<CODE>`

* `<REDIRECT_URI>` is url of this file:

~~~php
$bazaar = new Bazaar(new Config([
    'client-secret' => 'your-client-secret',
    'client-id' => 'your-client-id'
]));

$token = $bazaar->token('<REDIRECT_URI>');

echo "Refresh Token: " . $token->refreshToken();
~~~

**Here is the full example: [authorization.php](https://github.com/nikapps/bazaar-api-php/blob/master/examples/authorization.php)**


### Setting up config

As you can see in previous section, we create a `Config` instance and set `client-id` and `client-secret`.

For other api calls, we also should set `refresh-token` and `storage`.

~~~php
$bazaar = new Bazaar(new Config([
    'client-secret' => 'your-client-secret',
    'client-id' => 'your-client-id',
    'refresh-token' => 'refresh-token-123456',
    'storage' => new FileTokenStorage(__DIR__ . '/token.json')
]));
~~~

The `storage` handles storing and retrieving `access_token`. in this package we have two different storages:

* `FileTokenStorage` which store token in a file.
* `MemoryTokenStorage` which does not persist the token and you can only use it in current request.



## Usage


### Purchase

Here is the example of getting state of a purchase:

~~~php
$purchase = $bazaar->purchase('com.example.app', 'product-id (sku)', 'purchase-token');

if ($purchase->failed()) {
    echo $purchase->errorDescription();
} else {
    echo "Purchased: " . $purchase->purchased();
    echo "Consumed: " . $purchase->consumed();
    echo "Developer Payload: " . $purchase->developerPayload();
    echo "Purchase Time (Timestamp in ms): " . $purchase->time();
}
~~~

**Full Example: [purchase.php](https://github.com/nikapps/bazaar-api-php/blob/master/examples/purchase.php)**

Here is the example of getting state of a subscription:


### Subscription

~~~php
$subscription = $bazaar->subscription('com.example.app', 'subscription-id (sku)', 'purchase-token');

if ($subscription->failed()) {
    echo $subscription->errorDescription();
} else {
    echo "Start Time (Timestamp in ms): " . $subscription->startTime(); // initiationTime()
    echo "End Time (Timestamp in ms): " . $subscription->endTime(); // expirationTime(), nextTime()
    echo "Is auto renewing? " . $subscription->autoRenewing();
    echo "Is expired? (end time is past) " . $subscription->expired();
}
~~~

**Full Example: [subscription.php](https://github.com/nikapps/bazaar-api-php/blob/master/examples/subscription.php)**

### Cancel Subscription (Unsubscribe)

Here is the example of how you can cancel a subscription:

~~~php
$unsubscribe = $bazaar->unsubscribe('com.example.app', 'subscription-id (sku)', 'purchase-token');

if ($unsubscribe->successful()) {
    echo "The subscription has been successfully cancelled!";
} else {
    echo $unsubscribe->errorDescription();
}
~~~

**Full Example: [unsubscribe.php](https://github.com/nikapps/bazaar-api-php/blob/master/examples/unsubscribe.php)**

## Customization

### Custom Token Storage

If you want to store the token somewhere else (maybe database or redis?!), you can implement the `TokenStorageInterface`

~~~php
class CustomTokenStorage implements TokenStorageInterface {

    public function save(Token $token)
    {
    	// store access token
    }

    public function retrieve()
    {
    	// return access token
    }

    public function expired()
    {
    	// is token expired?
    }

}
~~~

## Examples

See: [https://github.com/nikapps/bazaar-api-php/blob/master/examples/](https://github.com/nikapps/bazaar-api-php/blob/master/examples/)

## Dependencies

* [GuzzleHttp (~5.3|~6.1)](https://packagist.org/packages/guzzlehttp/guzzle)


## Testing
Run: 

```
phpunit
```

## Official Documentation

* [Developer API (Persian/Farsi)](https://cafebazaar.ir/developers/docs/developer-api/v2/getting-started/?l=fa)
* [Developer API (English)](https://cafebazaar.ir/developers/docs/developer-api/v2/getting-started/?l=en)


## Contribute

Wanna contribute? simply fork this project and make a pull request!


## License
This project released under the [MIT License](http://opensource.org/licenses/mit-license.php).

```
/*
 * Copyright (C) 2015-2016 NikApps Team.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * 1- The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * 2- THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */
```

## Donation

[![Donate via Paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=G3WRCRDXJD6A8)
