<?php
namespace Nikapps\BazaarApi\Tests;

use Nikapps\BazaarApi\Bazaar;
use Nikapps\BazaarApi\Client\ClientInterface;
use Nikapps\BazaarApi\Config;
use Nikapps\BazaarApi\Storage\TokenStorageInterface;

class TestCase extends \PHPUnit_Framework_TestCase
{

    protected $client;
    protected $storage;

    protected function makeBazaar()
    {
        $this->client = $this->prophesize(ClientInterface::class);
        $this->storage = $this->prophesize(TokenStorageInterface::class);

        $config = new Config([
            'client-secret' => 'client-secret',
            'client-id' => 'client-id',
            'refresh-token' => 'refresh-token',
            'storage' => $this->storage->reveal(),
        ]);

        return new bazaar($config, $this->client->reveal());
    }

    protected function setStorage()
    {
        $this->storage
            ->expired()
            ->willReturn(false);

        $this->storage
            ->retrieve()
            ->willReturn('token-123456');
    }

    protected function setClient($method, $url, $options, $response)
    {
        $this->client
            ->$method($url, $options)
            ->willReturn($response);
    }


    protected function makePurchaseUrl($package, $id, $purchaseToken)
    {
        $config = new Config();

        return strtr($config->url('purchase'), [
            ':package_name' => $package,
            ':purchase_id' => $id,
            ':purchase_token' => $purchaseToken
        ]);
    }


    protected function makeSubscriptionUrl($package, $id, $purchaseToken)
    {
        $config = new Config();

        return strtr($config->url('subscription'), [
            ':package_name' => $package,
            ':subscription_id' => $id,
            ':purchase_token' => $purchaseToken
        ]);
    }


    protected function makeUnsubscribeUrl($package, $id, $purchaseToken)
    {
        $config = new Config();

        return strtr($config->url('unsubscribe'), [
            ':package_name' => $package,
            ':subscription_id' => $id,
            ':purchase_token' => $purchaseToken
        ]);
    }

    protected function makeTokenUrl()
    {
        return (new Config())->url('token');
    }
}