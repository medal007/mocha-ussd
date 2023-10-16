<?php
    function makeTransfer($url, $phone, $recipient, $amount) {
        $curl = curl_init();
    
        $data = [
            'phone' => $phone,
            'recipient' => $recipient,
            'amount' => $amount,
        ];
    
        $data_json = json_encode($data);
    
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data_json,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "User-Agent: insomnia/2023.5.8",
            ],
        ]);
    
        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            return json_encode(['error' => "cURL Error #" . $err]);
        } else {
            if ($httpStatus === 200) {
                return "success";
            } else {
                $errorResponse = json_decode($response, true);
                if (is_array($errorResponse) && isset($errorResponse['error'])) {
                    return json_encode(['error' => $errorResponse['error']]);
                }
            }
        }
    }
?>