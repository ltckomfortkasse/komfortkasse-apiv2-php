<?php

// Komfortkasse API v2 example
// small helper for calls to the API v2

include_once __DIR__ . '/komfortkasse_settings.php';

/**
 * Calls the Komfortkasse API v2 and returns array(HTTP status code, decoded JSON response or raw body).
 *
 * @param string $method GET or POST
 * @param string $path path below the base URL, e.g. /order/12345
 * @param array|null $body request body (sent as JSON)
 */
function komfortkasseApi($method, $path, $body = null)
{
    global $apikey, $apiBaseUrl;

    $headers = array('X-Komfortkasse-API-Key: ' . $apikey, 'Accept: application/json');
    $ch = curl_init($apiBaseUrl . $path);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    // the API key is sent with every request: HTTPS only, certificate verified (cURL default), no redirects
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    if ($method === 'POST') {
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return array(0, $error);
    }
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $json = json_decode($response, true);
    return array($status, $json === null ? $response : $json);
}
