<?php namespace Nikapps\BazaarApiPhpTests\Mocks;

class MockCancelSubscriptionResponse extends MockResponse {

    public function getSuccessfulCancelSubscriptionResponse() {

        $response = '';

        return $this->getPlainTextResponse($response);

    }

    public function getNotFoundCancelSubscriptionResponse() {

        //{"error_code": 404, "error_msg": "Not Found"}
        $response = [
            "error_code" => 404,
            "error_msg"  => "Not Found"
        ];

        return $this->getJsonResponse($response);

    }
} 