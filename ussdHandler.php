<?php
// ussdHandler.php
require './handlerController/MyAccountHandler.php';
require './handlerController/WalletAddressHandler.php';
require './handlerController/TransferHandler.php';

class USSDHandlerBase {
    protected $sessionId;
    protected $serviceCode;
    protected $phoneNumber;
    protected $text;
    protected $endpoint_url;
    protected $transfer_url;

    //Initializing the handler
    public function __construct($sessionId, $serviceCode, $phoneNumber, $text, $endpoint_url, $transfer_url) {
        $this->sessionId = $sessionId;
        $this->serviceCode = $serviceCode;
        $this->phoneNumber = $phoneNumber;
        $this->text = $text;
        $this->transfer_url = $transfer_url;
    }
    
    //Default USSD Response based on the $handlerMappings
    public function handle() {
        $response  = "CON Welcome to MoCha. \n";
        $response .= "1. Check balance \n";
        $response .= "2. Make transfer \n";
        $response .= "3. My wallet address \n";
        $response .= "4. Transaction history \n";
        return $response;
    }
}
