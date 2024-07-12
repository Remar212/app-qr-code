<?php 
require __DIR__ . '/vendor/autoload.php';

use Wecreative\AppQrCodeAPI\Client;
use Wecreative\AppQrCodeAPI\AppQrCode;

$client = new Client( 'your_api_key' );
$appQrCode = new AppQrCode( $client );

$data = [
    "frame_name" => "no-frame",
    "qr_code_text" => "https://www.qr-code-generator.com/",
    "image_format" => "SVG",
    "qr_code_logo" => "scan-me-square"
];

$res = $appQrCode->create( 'qr_code_name', $data );