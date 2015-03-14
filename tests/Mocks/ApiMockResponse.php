<?php namespace Nikapps\BazaarApiPhpTests\Mocks;

class ApiMockResponse extends MockResponse {

    public function getExpiredAccessTokenResponse() {

        $response = 'Access token has been expired';

        return $this->getPlainTextResponse($response);
    }

    public function getInvalidPackageNameResponse() {

        $response = 'Not a valid package name';

        return $this->getPlainTextResponse($response);

    }

    public function getInvalidAccessToken() {

        $response = 'Invalid access_token';

        return $this->getPlainTextResponse($response);

    }

    public function getUnAuthorizedResponse() {
        $response = '';

        return $this->getPlainTextResponse($response, 401);

    }

    public function getSuccessfulRefreshTokenResponse() {

        $response = [
            "access_token" => "uX5qC82EGWjkjjeyvTzTufHOM9HZfM",
            "token_type"   => "Bearer",
            "expires_in"   => 3600,
            "scope"        => "androidpublisher"
        ];

        return $this->getJsonResponse($response);

    }

    public function getSuccessfulFetchRefreshTokenResponse() {

        $response = [
            "access_token"  => "GWObRK06KHLr8pCQzDXJ9hcDdSC3eV",
            "token_type"    => "Bearer",
            "expires_in"    => 3600,
            "refresh_token" => "yBC4br1l6OCNWnahJvreOchIZ9B6ze",
            "scope"         => "androidpublisher"
        ];

        return $this->getJsonResponse($response);

    }
} 