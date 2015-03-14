<?php namespace Nikapps\BazaarApiPhp\Handlers;

use Nikapps\BazaarApiPhp\Models\Responses\BazaarApiResponse;

interface BazaarResponseHandlerInterface {

    /**
     * handle json response
     *
     * @param array $responseJson
     */
    public function handle($responseJson);

    /**
     * @return BazaarApiResponse
     */
    public function getResponseModel();

}