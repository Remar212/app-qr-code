# AppQrCode API Client

## Installation

Install the package through composer.  
For the latest stable version use:

```
php composer.phar require wecreative/app-qr-code
```

### Basic usage

You can define your own directory: define( 'APP_QR_CODE_IMAGES_DIRECTORY', 'YOUR_DIRECTORY' );

```php
<?php
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
```

````
More information about creating qrcodes https://www.qr-code-generator.com/qr-code-api/
````