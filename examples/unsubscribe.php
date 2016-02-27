<?php

use Nikapps\BazaarApi\Bazaar;
use Nikapps\BazaarApi\Config;
use Nikapps\BazaarApi\Storage\FileTokenStorage;

require_once __DIR__ . '/../vendor/autoload.php';

// We need a file to store access token. keep it in private!

$bazaar = new Bazaar(new Config([
    'client-secret' => 'your-client-secret',
    'client-id' => 'your-client-id',
    'refresh-token' => 'refresh-token-123456',
    'storage' => new FileTokenStorage(__DIR__ . '/token.json')
]));

// Which subscription do you want to unsubscribe/cancel?
// it also automatically refreshes token if needed
$unsubscribe = $bazaar->unsubscribe('com.example.app', 'subscription-id (sku)', 'purchase-token');

if ($unsubscribe->successful()) {
    echo "The subscription has been successfully cancelled!";
} else {
    echo $unsubscribe->errorDescription();
}