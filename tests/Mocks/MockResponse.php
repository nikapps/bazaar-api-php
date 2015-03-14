<?php namespace Nikapps\BazaarApiPhpTests\Mocks;

use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class MockResponse {

    /**
     * get json response
     *
     * @param $json
     * @param int $statusCode
     * @return Response
     */
    public function getJsonResponse($json, $statusCode = 200) {

        if (is_array($json)) {
            $json = json_encode($json);
        }
        $body = Stream::factory($json);

        $headers = [
            'Content-Type' => 'application/json'
        ];

        return new Response($statusCode, $headers, $body);
    }

    /**
     * get plain text response
     *
     * @param $text
     * @param int $statusCode
     * @return Response
     */
    public function getPlainTextResponse($text, $statusCode = 200){

        $body = Stream::factory($text);

        $headers = [
            'Content-Type' => 'text/plain'
        ];

        return new Response($statusCode, $headers, $body);
    }
} 