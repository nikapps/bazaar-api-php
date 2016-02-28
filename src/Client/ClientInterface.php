<?php
namespace Nikapps\BazaarApi\Client;

interface ClientInterface
{

    /**
     * Send a get request
     *
     * @param $url
     * @param array $options
     * @return array
     */
    public function get($url, array $options = []);

    /**
     * Send a post request
     *
     * @param $url
     * @param array $options
     * @return array
     */
    public function post($url, array $options = []);
}