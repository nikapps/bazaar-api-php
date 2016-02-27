<?php
namespace Nikapps\BazaarApi\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GuzzleClient implements ClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * GuzzleClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = is_null($client) ? new Client() : $client;
    }

    /**
     * Send a get request
     *
     * @param $url
     * @param array $options
     * @return array
     */
    public function get($url, array $options)
    {
        try {
            $response = $this->client->get($url, $options);

        } catch (RequestException $e) {
            if(!$e->hasResponse()) {
                throw $e;
            }
            $response = $e->getResponse();
        }

        return json_decode(
            $response->getBody()->getContents()
        );
    }

    /**
     * Send a post request
     *
     * @param $url
     * @param array $options
     * @return array
     */
    public function post($url, array $options)
    {
        try {
            $response = $this->client->post($url, $options);

        } catch (RequestException $e) {
            if(!$e->hasResponse()) {
                throw $e;
            }
            $response = $e->getResponse();
        }

        return json_decode(
            $response->getBody()->getContents()
        );
    }
}