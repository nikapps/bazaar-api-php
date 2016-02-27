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

// Set your purchase info (package name, product id (SKU) and purchase token)
// it also automatically refreshes token if needed
$purchase = $bazaar->purchase('com.example.app', 'product-id (sku)', 'purchase-token');

if ($purchase->failed()) {
    echo $purchase->errorDescription();
} else {
    echo "Purchased: " . $purchase->purchased();
    echo "Consumed: " . $purchase->consumed();
    echo "Developer Payload: " . $purchase->developerPayload();
    echo "Purchase Time (Timestamp in ms): " . $purchase->time();
}