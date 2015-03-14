<?php namespace Nikapps\BazaarApiPhpTests\Mocks;

class MockPurchaseResponse extends MockResponse {


    public function getSuccessfulPurchaseResponse() {

        $response = [
            "consumptionState" => 1,
            "purchaseState"    => 0,
            "kind"             => "androidpublisher#inappPurchase",
            "developerPayload" => "something",
            "purchaseTime"     => 1414181378566
        ];

        return $this->getJsonResponse($response);

    }


    public function getNotFoundPurchaseResponse(){

        $response = [];

        return $this->getJsonResponse($response);

    }



}