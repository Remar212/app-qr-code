<?php
namespace Wecreative\AppQrCodeAPI\Exception;

class InvalidArgumentException extends AppQrCodeException {
    /**
     * @var array
     */
    protected $argumentValue;

    public function __construct( $message, $argumentValue,  $code = 0, \Exception $previous = null ) {
        $this->argumentValue = $argumentValue;

        parent::__construct( $message, $code, $previous );
    }

    public function getArgumentValue() {
        return $this->parameterValue;
    }
}