<?php 
namespace Wecreative\AppQrCodeAPI;

use Wecreative\AppQrCodeAPI\Client;
use Wecreative\AppQrCodeAPI\Exception\InvalidArgumentException;

class AppQrCode {

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string $imagesDirectory
     */
    protected $imagesDirectory;

    /**
     * @param Client $client
     */
    public function __construct( Client $client ) {
        $this->client = $client;
        $this->imagesDirectory = defined( 'APP_QR_CODE_IMAGES_DIRECTORY' ) ? APP_QR_CODE_IMAGES_DIRECTORY : __DIR__ . '/qr-codes';
    }

    /**
     * Create qr code
     * 
     * @param array $data
     * @param string $qrCodeId
     */
    public function create( $qrCodeId,  array $data ) {
        $response =  $this->client->doPost( 'create', $data );

        if ( $response ) {
            $fileFormat = isset( $data['image_format'] ) ? strtolower( $data['image_format'] ) : 'svg';

            if ( $fileFormat == 'svg' ) {
                $response = $this->fixSvg( $response );
            }

            $save = $this->save( $response, $qrCodeId . '.' . $fileFormat );

            if ( $save ) {
                return [
                    'dir'           => $this->imagesDirectory . '/' . $qrCodeId . '.' . $fileFormat,
                    'file_content'  => $response,
                    'file'          => $qrCodeId . '.' . $fileFormat , 
                ];
            }

            return $save;
        }   

        return $response;
    }


    /**
     * @param string $content
     * @param string $qrCodeId
     * @param string $format
     */
    public function save( $content, $file ) {
        if ( ! is_dir( $this->imagesDirectory ) ) {
            mkdir( $this->imagesDirectory );
        }

        return file_put_contents(
            $this->imagesDirectory . '/' . $file,
            $content
        );
    }

    public function fixSvg( $svg ) {
        $fixedSvg = preg_replace( '/<svg[^>]*>/', '', $svg, 1 );
        $fixedSvg = str_replace( '</svg>', '', $fixedSvg );
        
        $correctedSvg = $fixedSvg . '</svg>';
        
        return $correctedSvg;
    }

    public function delete( $qrCode ) {
        if ( file_exists( $this->imagesDirectory . '/' . $qrCode ) ) {
            return unlink( $this->imagesDirectory . '/' . $qrCode );
        }
    }
}