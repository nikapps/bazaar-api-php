<?php namespace Nikapps\BazaarApiPhp\Models\Responses;

abstract class BazaarApiResponse {

    /**
     * @var array
     */
    private $jsonArray = [];

    /**
     * get response json
     *
     * @return array
     */
    public function getResponseJson() {
        return $this->jsonArray;
    }

    /**
     * set response json
     *
     * @param array $json
     */
    public function setResponseJson($json) {
        if(!is_array($json)){
            $json = json_decode($json, true);
        }

        $this->jsonArray = $json;
    }


} 