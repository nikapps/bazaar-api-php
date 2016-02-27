<?php

// 1. Create a client in your developer panel
// 2. Go to https://pardakht.cafebazaar.ir/devapi/v2/auth/authorize/?response_type=code&access_type=offline&redirect_uri=<REDIRECT_URI>&client_id=<CLIENT_ID>
//  (<redirect url> is url of this script).
// 3. Store the refresh token

use Nikapps\BazaarApi\Bazaar;
use Nikapps\BazaarApi\Config;

require_once __DIR__ . '/../vendor/autoload.php';

$bazaar = new Bazaar(new Config([
    'client-secret' => 'your-client-secret',
    'client-id' => 'your-client-id'
]));

$redirectUrl = 'http://example.com/callback';

$token = $bazaar->token($redirectUrl);

if ($token->failed()) {
    echo $token->errorDescription();
} else {
    echo "Refresh Token: " . $token->refreshToken();
}