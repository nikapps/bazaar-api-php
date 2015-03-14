<?php namespace Nikapps\BazaarApiPhp\Handlers;

use Nikapps\BazaarApiPhp\Exceptions\InvalidJsonException;
use Nikapps\BazaarApiPhp\Models\Responses\BazaarApiResponse;
use Nikapps\BazaarApiPhp\Models\Responses\RefreshToken;

class RefreshTokenHandler implements BazaarResponseHandlerInterface {

    /**
     * @var RefreshToken
     */
    protected $refreshToken;

    /**
     * handle json response
     *
     * @param array $responseJson
     * @throws InvalidJsonException
     */
    public function handle($responseJson) {

        $this->refreshToken = new RefreshToken();
        $this->refreshToken->setResponseJson($responseJson);

        $this->isJsonValid($responseJson);

        $this->refreshToken->setAccessToken($responseJson['access_token']);
        $this->refreshToken->setTokenType($responseJson['token_type']);
        $this->refreshToken->setExpireIn($responseJson['expires_in']);
        $this->refreshToken->setScope($responseJson['scope']);
    }

    /**
     * @return RefreshToken
     */
    public function getResponseModel() {

        return $this->refreshToken;
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
            'scope'
        ];

        if (0 === count(array_diff($keysShouldExist, array_keys($responseJson)))) {
            return true;
        } else {
            throw new InvalidJsonException;
        }
    }

} 