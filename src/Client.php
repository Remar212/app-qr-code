<?php

namespace Wecreative\AppQrCodeAPI;

use Wecreative\AppQrCodeAPI\Exception\InvalidRequestException;
use Wecreative\AppQrCodeAPI\Exception\InvalidArgumentException;

/**
 * App Qr Code API implementation.
 *
 * @author Damian Remarczyk <damian.remarczyk@netinteractive.pl>
 */
class Client {
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    /**
     * @var array
     */
    protected $config;


    /**
     * Initialization.
     */
    public function __construct( $apiKey, $endPoint = 'https://api.qr-code-generator.com/v1/' ) {
        $this->config = [
            'endpoint' => rtrim( $endPoint, '/' ) . '/',
            'api_key' => $apiKey
        ];

        foreach ( $this->config as $key => $parameter ) {
            if ( empty( $parameter ) ) {
                throw new InvalidArgumentException( $key . ' parameter is required', $parameter );
            }
        }
    }

    /**
     * Send POST request to AppQrCode API.
     *
     * @param  string $method API Method
     * @param  array  $data   Request data
     * @return array
     */
    public function doPost( $method, array $data ) {
        return $this->doRequest( self::METHOD_POST, $method, $data );
    }

    /**
     * Send GET request to SalesManago API.
     *
     * @param  string $method API Method
     * @param  array  $data   Request data
     * @return array
     */
    public function doGet( $method, array $data ) {
        return $this->doRequest(self::METHOD_GET, $method, $data);
    }

    /**
     * Send request to AppQrCode API.
     *
     * @param  string $method    HTTP Method
     * @param  string $apiMethod API Method
     * @param  array  $data      Request data
     * @return array
     */
    protected function doRequest( $method, $apiMethod, array $data = [] ) {
        $url = $this->config['endpoint'] . $apiMethod;
        $data = $this->mergeData( $this->createAuthData(), $data );

        if ( $method === 'POST' ) $url .= '?' . http_build_query( $this->createAuthData() );
        
        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        if ( $data)  {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ( ! $httpStatus === 200 ) {
            throw new InvalidRequestException( $method, $url, $data, $response) ;
        }

        return $response;
    }

    /**
     * Returns an array of authentication data.
     *
     * @return array
     */
    protected function createAuthData() {
        return [
            'access-token' => $this->config['api_key'],
        ];
    }

    /**
     * Merge data and removing null values.
     *
     * @param  array $base         The array in which elements are replaced
     * @param  array $replacements The array from which elements will be extracted
     * @return array
     */
    private function mergeData( array $base, array $replacements ) {
        return array_filter( array_merge( $base, $replacements ), function( $value ) {
            return $value !== null;
        } );
    }
}