<?php
    require './utils/makeTransfer.php';
    
    class TransferHandler extends USSDHandlerBase {
        public function handle() {
            // Business logic for My phone number
            $get_text = $this->text;
            $make_transfer_url = $this->transfer_url .'/transfer?display=SMS';
            $numberOfLevel = substr_count($get_text, '*');
            
            if (strlen($get_text) < 2) {
                $response  = "CON Enter recipients phone number to make transfer. \n";
            }else if(strlen($get_text) >= 2 && $numberOfLevel == 1){
                $response  = "CON Enter the amount of funds you want to send (E.g. 0.01).";
            }else if(strlen($get_text) >= 2 && $numberOfLevel == 2){
                
                $arrText = explode('*', $get_text);
                $phone = '23276242792';
                $recipient = $arrText[1];  // Array index 1 is the recipient
                $amount = $arrText[2];    // Array index 2 is the amount
                
                $result = makeTransfer($make_transfer_url, $phone, $recipient, $amount);
                if ($result === "success") {
                    //success USSD Response
                    $response  = "END Your request is been processed, you will receive an SMS to confirm your transfer.";
                } else {
                    //failed USSD Response
                    $response = "END ". ucwords($result);
                }
            
            }
            return $response;
        }
    }
