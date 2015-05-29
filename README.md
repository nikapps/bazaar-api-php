# Bazaar-Api-PHP (BazaarApi for PHP)

## Installation
Using [Composer](https://getcomposer.org), add this [package](https://packagist.org/packages/nikapps/bazaar-api-php) dependency to your composer.json :

```
composer require nikapps/bazaar-api-php
```


## Configuration

#### Create client
First of all, you should go to your cafebazaar panel and get `client id` and `client secret`.

* Login to your panel and go to this url: *(Developer API section)*
`http://pardakht.cafebazaar.ir/panel/developer-api/?l=fa`

* Click on `new client` and enter your redirect uri (it's needed to get returned `code` and `refresh_token`)

* Change your configuration file and set your `client_id`, `client_secret` and `redirect_uri`.

#### Account Config
Before you can call any api call, you should set your credentials.

~~~php
$accountConfig = new \Nikapps\BazaarApiPhp\Configs\AccountConfig();

$accountConfig->setClientId('your_client_id')
              ->setClientSecret('your_client_secret')
              ->setRefreshToken('your_refresh_token');

//for getting refresh-token
$accountConfig->setCode('your_returned_code')
              ->setRedirectUri('your_redirect_uri');

~~~

**for getting refresh token see next step.**

#### Get refresh token
* Open this url in your browser:

```
https://pardakht.cafebazaar.ir/auth/authorize/?response_type=code&access_type=offline&redirect_uri=<REDIRECT_URI>&client_id=<CLIENT_ID>
```
*- don't forget to change `<REDIRECT_URI>` and `<CLIENT_ID>`.*

* After clicking on accept/confirm button, you will be redirected to: `<REDIRECT_URI>?code=<CODE>`

*- copy  `<CODE>`*


* Run code:

~~~php
$bazaarApi = new \Nikapps\BazaarApiPhp\BazaarApi($accountConfig);

$authorizationRequest = new \Nikapps\BazaarApiPhp\Models\Requests\AuthorizationRequest();

$fetchRefreshToken = $bazaarApi->fetchRefreshToken($authorizationRequest);

//echo refresh token
echo $fetchRefreshToken->getRefreshToken();
~~~

* Copy `refresh_token` and save it.

#### Done!


## Usage


#### Purchase

~~~php
//creating token manager based on file
$tokenManager = new \Nikapps\BazaarApiPhp\TokenManagers\FileTokenManager();
$tokenManager->setPath('/path/to/stored/token.json');

$bazaarApi = new \Nikapps\BazaarApiPhp\BazaarApi($accountConfig);
$bazaarApi->setTokenManager($tokenManager);

//creating purchase request model
$purchaseRequest = new \Nikapps\BazaarApiPhp\Models\Requests\PurchaseStatusRequest();
$purchaseRequest->setPackage('com.package.name');
$purchaseRequest->setProductId('product_id');
$purchaseRequest->setPurchaseToken('purchase_token');

//get purchase status
$purchase = $bazaarApi->getPurchase($purchaseRequest);

echo "Developer Payload: " . $purchase->getDeveloperPayload();
echo "PurchaseTime: " . $purchase->getPurchaseTime(); //instance of Carbon
echo "Consumption State: " . $purchase->getConsumptionState();
echo "Purchase State: " . $purchase->getPurchaseState();
~~~

#### Subscription

~~~php
//creating token manager based on file
$tokenManager = new \Nikapps\BazaarApiPhp\TokenManagers\FileTokenManager();
$tokenManager->setPath('/path/to/stored/token.json');

$bazaarApi = new \Nikapps\BazaarApiPhp\BazaarApi($accountConfig);
$bazaarApi->setTokenManager($tokenManager);

//creating subscription request model
$subscriptionRequest = new \Nikapps\BazaarApiPhp\Models\Requests\SubscriptionStatusRequest();
$subscriptionRequest->setPackage('com.package.name');
$subscriptionRequest->setSubscriptionId('subscription_id');
$subscriptionRequest->setPurchaseToken('purchase_token');

//get subscription status
$subscription = $bazaarApi->getSubscription($subscriptionRequest);

echo "Initiation Time: " . $subscription->getInitiationTime(); // instance of Carbon
echo "Expiration Time: " . $subscription->getExpirationTime(); // instance of Carbon
echo "Auto Renewing: " . $subscription->isAutoRenewing(); // boolean
~~~

#### Cancel Subscription

~~~php
//creating token manager based on file
$tokenManager = new \Nikapps\BazaarApiPhp\TokenManagers\FileTokenManager();
$tokenManager->setPath('/path/to/stored/token.json');

$bazaarApi = new \Nikapps\BazaarApiPhp\BazaarApi($accountConfig);
$bazaarApi->setTokenManager($tokenManager);

//creating cancel subscription request model
$cancelSubscriptionRequest = new \Nikapps\BazaarApiPhp\Models\Requests\CancelSubscriptionRequest();
$cancelSubscriptionRequest->setPackage('com.package.name');
$cancelSubscriptionRequest->setSubscriptionId('subscription_id');
$cancelSubscriptionRequest->setPurchaseToken('purchase_token');

//cancel subscription
$cancelSubscription = $bazaarApi->cancelSubscription($cancelSubscriptionRequest);

echo "Is Cancelled: " . $cancelSubscription->isCancelled();
~~~

#### Refresh Token

~~~php
$bazaarApi = new \Nikapps\BazaarApiPhp\BazaarApi($accountConfig);

$refreshTokenRequest = new \Nikapps\BazaarApiPhp\Models\Requests\RefreshTokenRequest();
$refreshToken = $bazaarApi->refreshToken($refreshTokenRequest);

echo "Access Token: " . $refreshToken->getAccessToken();
~~~

## Exceptions
* **BazaarApiException**

*Parent of other exceptions.*

* **ExpiredAccessTokenException**

*When token is expired*

* **InvalidJsonException**

*When response has invalid json key(s)*

* **InvalidPackageNameException**

*When package name is invalid*

* **InvalidTokenException**

*When token is invalid*

* **NetworkErrorException**

*Guzzle ClientExcpetion*

you can get guzzle exception by `getClientException`


* **NotFoundException**

*When purchase or subscrtion is not found*

## Customization

#### Custom Token Manager

Token manager manages loading,storing and checking expiration of access token. By default you can use `FileTokenManager` is provided by this package and store access token in file.

If you want to have a custom token mangaer and storing tokens in your database or cache, you can implement `TokenManagerInterface`.

~~~php
class CustomTokenManager implements \Nikapps\BazaarApiPhp\TokenManagers\TokenManagerInterface{

    /**
     * when access token is received from CafeBazaar, this method will be called.
     *
     * @param string $accessToken access-token
     * @param int $ttl number of seconds remaining until the token expires
     * @return mixed
     */
    public function storeToken($accessToken, $ttl) {
        // TODO: Implement storeToken() method.
    }

    /**
     * when access token is needed, this method will be called.
     *
     * @return string
     */
    public function loadToken() {
        // TODO: Implement loadToken() method.
    }

    /**
     * should we refresh token? (based on ttl)
     *
     * @return bool
     */
    public function isTokenExpired() {
        // TODO: Implement isTokenExpired() method.
    }

}
~~~

Then, you can use it in this way :

~~~php
$bazaarApi = new \Nikapps\BazaarApiPhp\BazaarApi($accountConfig);

$customTokenManager = new CustomTokenManager();
$bazaarApi->setTokenManager($customTokenManager);
~~~


## Dependencies

* [GuzzleHttp 5.2.x](https://packagist.org/packages/guzzlehttp/guzzle)
* [Carbon 1.x](https://packagist.org/packages/nesbot/carbon)



## Testing
Run: 

```
phpunit
```

## Bazaar Responses

#### Purchase: 
![Purchase Response - CafeBazaar Api](https://www.dropbox.com/s/0jya8qr0hamvdyb/purchase.png?raw=1)

#### Subscription: 
![Subscription Response - CafeBazaar Api](https://www.dropbox.com/s/gph2in3ii7jnmcy/subscription.png?raw=1)

#### Cancel Subscription: 
![Cancel Subscription Response - CafeBazaar Api](https://www.dropbox.com/s/2qhmisxdgzicdek/cancel_subscription.png?raw=1)

## Simple Demo!

This is a very simple demo:

~~~php
<?php
use Nikapps\BazaarApiPhp\BazaarApi;
use Nikapps\BazaarApiPhp\Configs\AccountConfig;
use Nikapps\BazaarApiPhp\Exceptions\NotFoundException;
use Nikapps\BazaarApiPhp\Models\Requests\PurchaseStatusRequest;
use Nikapps\BazaarApiPhp\Models\Responses\Purchase;
use Nikapps\BazaarApiPhp\TokenManagers\FileTokenManager;

//load composer autoloader
require_once __DIR__ . '/vendor/autoload.php';


//set account config
$accountConfig = new AccountConfig();

$accountConfig->setClientId('your_client_id')
    ->setClientSecret('your_client_secret')
    ->setRefreshToken('your_refresh_token');

//set file token manager
$fileTokenManager = new FileTokenManager();
$fileTokenManager->setPath(__DIR__ . '/somewhere/safe/token.json');

//initiating BazaarApi
$bazaarApi = new BazaarApi();
$bazaarApi->setAccountConfig($this->getAccountConfig());
$bazaarApi->setTokenManager($fileTokenManager);

//creating a purchase status request
$purchaseStatusRequest = new PurchaseStatusRequest();
$purchaseStatusRequest->setPackage('com.package.name')
    ->setProductId('product_id')
    ->setPurchaseToken('purchase_token');

//REQUESTING:
try {
    //get purchase status from cafe bazaar
    $purchase = $bazaarApi->getPurchase($purchaseStatusRequest);

    if ($purchase->getConsumptionState() == Purchase::CONSUMPTION_STATUS_CONSUMED) {
        // purchase is consumed
    }

    if ($purchase->getPurchaseState() == Purchase::PURCHASE_STATUS_PURCHASED) {
        // purchased
    }

    echo "Purchase Time: " . $purchase->getPurchaseTime();

} catch (NotFoundException $e) {
    // purchase is not found!

} catch (Exception $e) {

    /*
     * Other exceptions:
     *
     * @throws Exceptions\ExpiredAccessTokenException
     * @throws Exceptions\InvalidPackageNameException
     * @throws Exceptions\InvalidTokenException
     * @throws Exceptions\NetworkErrorException
     * @throws Exceptions\InvalidJsonException
     */

}

~~~

## Contribute

Wanna contribute? simply fork this project and make a pull request!


## License
This project released under the [MIT License](http://opensource.org/licenses/mit-license.php).

```
/*
 * Copyright (C) 2015 NikApps Team.
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
