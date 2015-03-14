<?php namespace Nikapps\BazaarApiPhpTests\Mocks;


class MockSubscriptionResponse extends MockResponse {

    public function getSuccessfulSubscriptionResponse() {

        $response = [
            "kind"                    => "androidpublisher#subscriptionPurchase",
            "initiationTimestampMsec" => 1414181378566,
            "validUntilTimestampMsec" => 1435912745710,
            "autoRenewing"            => true,
        ];

        return $this->getJsonResponse($response);

    }

    public function getNotFoundSubscriptionResponse() {
        //{"error_code": 404, "error_msg": "Not Found"}
        $response = [
            "error_code" => 404,
            "error_msg"  => "Not Found"
        ];

        return $this->getJsonResponse($response);

    }
} 