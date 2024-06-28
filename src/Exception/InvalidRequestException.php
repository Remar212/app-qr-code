<?php
namespace Wecreative\AppQrCodeAPI\Exception;

use GuzzleHttp\Psr7\Response as Response;

class InvalidRequestException extends AppQrCodeException {
    /**
     * @var string
     */
    protected $requestMethod;

    /**
     * @var string
     */
    protected $requestUrl;

    /**
     * @var array
     */
    protected $requestData;

    /**
     * @var Response
     */
    protected $response;

    public function __construct( $requestMethod, $requestUrl, array $requestData, Response $response ) {
        $this->requestMethod = $requestMethod;
        $this->requestUrl = $requestUrl;
        $this->requestData = $requestData;
        $this->response = $response;
        $this->message = 'Error occured when sending request.';

        parent::__construct($this->message, 0, null);
    }

    public function getRequestMethod() {
        return $this->requestMethod;
    }

    public function getRequestUrl() {
        return $this->requestUrl;
    }

    public function getRequestData() {
        return $this->requestData;
    }

    public function getResponse() {
        return $this->response;
    }
}