<?php namespace Nikapps\BazaarApiPhp;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Message\FutureResponse;
use Nikapps\BazaarApiPhp\Exceptions\ExpiredAccessTokenException;
use Nikapps\BazaarApiPhp\Exceptions\InvalidJsonException;
use Nikapps\BazaarApiPhp\Exceptions\InvalidPackageNameException;
use Nikapps\BazaarApiPhp\Exceptions\InvalidTokenException;
use Nikapps\BazaarApiPhp\Exceptions\NetworkErrorException;
use Nikapps\BazaarApiPhp\Exceptions\NotFoundException;
use Nikapps\BazaarApiPhp\Handlers\BazaarResponseHandlerInterface;
use Nikapps\BazaarApiPhp\Models\Requests\BazaarApiRequest;
use Nikapps\BazaarApiPhp\Models\Responses\BazaarApiResponse;

class BazaarApiClient {


    /**
     * @var BazaarApiRequest
     */
    protected $request;

    /**
     * request options
     *
     * @var array
     */
    protected $requestOptions;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @param BazaarApiRequest $request
     */
    public function setRequest($request) {
        $this->request = $request;
    }

    /**
     * @param array $requestOptions
     */
    public function setRequestOptions($requestOptions) {
        $this->requestOptions = $requestOptions;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function setClient($client) {
        $this->client = $client;
    }


    /**
     * @throws ExpiredAccessTokenException
     * @throws InvalidPackageNameException
     * @throws InvalidTokenException
     * @throws NetworkErrorException
     * @throws NotFoundException
     * @throws InvalidJsonException
     * @return BazaarApiResponse
     */
    public function request(){
        $response = null;
        try {
            /** @var FutureResponse $response */
            if($this->request->isPost()){
                $response = $this->client->post($this->request->getUri(), $this->requestOptions);
            }else {
                $response = $this->client->get($this->request->getUri(), $this->requestOptions);
            }
        } catch (ClientException $e) {

            $networkException = new NetworkErrorException();
            $networkException->setClientException($e);

            throw $networkException;
        }

        $body = trim((string) $response->getBody());

        if(strtolower($body) == BazaarApiErrors::EXPIRED_ACCESS_TOKEN){
            throw new ExpiredAccessTokenException;

        }else if(strtolower($body) == BazaarApiErrors::INVALID_TOKEN){
            throw new InvalidTokenException;

        }else if(strtolower($body) == BazaarApiErrors::INVALID_PACKAGE_NAME){
            throw new InvalidPackageNameException;

        }

        $responseJson = json_decode($body, true);

        //{"error_code": 404, "error_msg": "Not Found"} for (cancel)? subscription
        if(isset($responseJson['error_code']) && $responseJson['error_code'] == 404){
            throw new NotFoundException;
        }

        $responseHandler = $this->request->getResponseHandler();

        $responseHandler->handle($responseJson);
        return $responseHandler->getResponseModel();

    }

} 