<?php namespace Nikapps\BazaarApiPhp\Handlers;

use Nikapps\BazaarApiPhp\Exceptions\InvalidJsonException;
use Nikapps\BazaarApiPhp\Models\Responses\BazaarApiResponse;
use Nikapps\BazaarApiPhp\Models\Responses\FetchRefreshToken;

class FetchRefreshTokenHandler implements BazaarResponseHandlerInterface {

    /**
     * @var FetchRefreshToken
     */
    protected $fetchRefreshToken;

    /**
     * handle json response
     *
     * @param array $responseJson
     * @throws InvalidJsonException
     */
    public function handle($responseJson) {

        $this->fetchRefreshToken = new FetchRefreshToken();
        $this->fetchRefreshToken->setResponseJson($responseJson);

        $this->isJsonValid($responseJson);

        $this->fetchRefreshToken->setAccessToken($responseJson['access_token']);
        $this->fetchRefreshToken->setTokenType($responseJson['token_type']);
        $this->fetchRefreshToken->setExpireIn($responseJson['expires_in']);
        $this->fetchRefreshToken->setRefreshToken($responseJson['refresh_token']);
        $this->fetchRefreshToken->setScope($responseJson['scope']);

    }

    /**
     * @return FetchRefreshToken
     */
    public function getResponseModel() {
        return $this->fetchRefreshToken;
    }

    /**
     * check json is valid or not
     *
     * @param $responseJson
     * @throws InvalidJsonException
     * @return bool
     */
    protected function isJsonValid($responseJson) {

        $keysShouldExist = [
            'access_token',
            'token_type',
            'expires_in',
            'refresh_token',
            'scope'
        ];

        if (0 === count(array_diff($keysShouldExist, array_keys($responseJson)))) {
            return true;
        } else {
            throw new InvalidJsonException;
        }
    }

} 