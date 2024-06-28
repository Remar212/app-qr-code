<?php 
require __DIR__ . '/vendor/autoload.php';

use Wecreative\AppQrCodeAPI\Client;
use Wecreative\AppQrCodeAPI\AppQrCode;

$client = new Client( 'yor_api_key' );
$appQrCode = new AppQrCode( $client );

$res = $appQrCode->create( [
    "frame_name" => "no-frame",
    "qr_code_text" => "https://www.qr-code-generator.com/",
    "image_format" => "SVG",
    "qr_code_logo" => "scan-me-square"
], 'xd1234');