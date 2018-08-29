<html>
<body>
<?php

// Komfortkasse API v2 Example
// This file will send an API call containing a test order to the komfortkasse API v2.

include_once ('komfortkasse_settings.php');

// first, build the example order
include_once ('komfortkasse_buildorder.php');

$order = getorder();

// $ch = curl_init('https://ssl.komfortkasse.eu/v2/order');

$ch = curl_init('https://localhost:8443/kkos01/api/v2/order');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => array(
                'X-Komfortkasse-API-Key: '.$apikey,
                'Content-Type: application/json'
        ),
        CURLOPT_POSTFIELDS => json_encode($order)
));

$response = curl_exec($ch);

// Check for errors
if($response === FALSE){
    die(curl_error($ch));
}

echo 'Result:<br/><br/>';
echo '<pre>';
echo $response;
echo '</pre>';

?>

</body>
</html>