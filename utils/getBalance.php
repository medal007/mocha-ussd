<?php
function getBalance($url) {
    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        curl_close($ch); // Close cURL session in case of error
        return false;
    }

    // Get the HTTP status code
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Close cURL session
    curl_close($ch);

    // Check for HTTP status code
    if ($httpStatus === 200) {
        return "success";
    } else {
        // Try to decode the response as JSON
        $errorResponse = json_decode($response, true);

        // Check if the JSON decoding was successful and if it contains an "error" field
        if (is_array($errorResponse) && isset($errorResponse['error'])) {
            return $errorResponse['error'];
        }
    }
}

?>
