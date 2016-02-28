<?php
namespace Nikapps\BazaarApi\Client;

interface ClientInterface
{

    /**
     * Send a get request
     *
     * @param string $url
     * @param array $options
     *
     * @return array
     */
    public function get($url, array $options = []);

    /**
     * Send a post request
     *
     * @param string $url
     * @param array $options
     *
     * @return array
     */
    public function post($url, array $options = []);
}
