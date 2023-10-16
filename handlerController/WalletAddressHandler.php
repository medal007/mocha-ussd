<?php
    require './utils/showWalletAddress.php';
    class WalletAddressHandler extends USSDHandlerBase {
        public function handle() {
            //Show Wallet Address from API Endpoint
            $show_wallet_address_url = $this->endpoint_url .'/me?phone='. $this->phoneNumber;
            $wallet_address_response = showWalletAddress($show_wallet_address_url);
            
            if($wallet_address_response === "success"){
                //success USSD Response
                $response = "END Your request has been received, you will receive an SMS containing your wallet address on: " . $this->phoneNumber;
                return $response;
            }else{
                //failed USSD Response
                $response = "END ". ucwords($wallet_address_response);
                return $response;
            }
        }
    }
