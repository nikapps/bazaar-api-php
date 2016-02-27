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

// Set your subscription info (package name, subscription id (SKU) and purchase token)
// it also automatically refreshes token if needed
$subscription = $bazaar->subscription('com.example.app', 'subscription-id (sku)', 'purchase-token');

if ($subscription->failed()) {
    echo $subscription->errorDescription();
} else {
    echo "Start Time (Timestamp in ms): " . $subscription->startTime(); // initiationTime()
    echo "End Time (Timestamp in ms): " . $subscription->endTime(); // expirationTime(), nextTime()
    echo "Is auto renewing? " . $subscription->autoRenewing();
    echo "Is expired? (end time is past) " . $subscription->expired();
}