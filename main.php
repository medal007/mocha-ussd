<?php
// main.php
require_once 'ussdHandler.php';
require_once __DIR__ . '/utils/envParser.php';
(new DotEnv(__DIR__ . '/.env'))->load();

//Getting the environment variable
$endpoint_url = getenv('ENDPOINT_URL');
$transfer_url = getenv('TRANSFER_URL');

// Read the variables sent via POST from Africa'sTalking API
$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];

// We defined a mapping of text inputs to handler classes
$handlerMappings = [
    "" => 'USSDHandlerBase',
    "1" => 'MyAccountHandler',
    "2" => 'TransferHandler',
    "3" => 'WalletAddressHandler',
    "4" => 'WithdrawHandler',
    "2*" => 'TransferHandler',
];

if (strlen($text) < 2 && isset($handlerMappings[$text])) {
    // Use the direct approach for single character input.
    $handlerClass = $handlerMappings[$text];
} elseif (strlen($text) >= 2) {
    // Check if the text contains any of the keys.
    foreach ($handlerMappings as $key => $class) {
        if (strpos($text, $key) !== false) {
            $handlerClass = $class;
            break;
        }
    }
}

if (isset($handlerClass)) {
    // Create an instance of the selected handler class.
    $handler = new $handlerClass($sessionId, $serviceCode, $phoneNumber, $text, $endpoint_url, $transfer_url);
    $response = $handler->handle();
} else {
    $response = "END Invalid input. Please try again.\n" . $filterout;
}


// Echo the response back to the API
header('Content-type: text/plain');
echo $response;