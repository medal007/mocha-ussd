<?php
    require './utils/getBalance.php';
    class MyAccountHandler extends USSDHandlerBase {
        public function handle() {
            //Get Balance from API Endpoint
            $get_balance_url = $this->endpoint_url .'/balance?phone='. $this->phoneNumber . '&display=SMS';
            $balance_response = getBalance($get_balance_url);
            
            if($balance_response === "success"){
                //success USSD Response
                $response = "END Your request has been received, you will receive an SMS containing your current balance on your number: " . $this->phoneNumber;
                return $response;
            }else{
                //failed USSD Response
                $response = "END ". ucwords($balance_response);
                return $response;
            }
        }
    }
