<?php

function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function createJWT($clientEmail, $privateKey, $projectId) {
    $now = time();
    $token = [
        'iss' => $clientEmail,
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token',
        'iat' => $now,
        'exp' => $now + 3600,
    ];

    $header = [
        'alg' => 'RS256',
        'typ' => 'JWT',
    ];

    $headerEncoded = base64UrlEncode(json_encode($header));
    $payloadEncoded = base64UrlEncode(json_encode($token));

    $signature = '';
    openssl_sign($headerEncoded . '.' . $payloadEncoded, $signature, $privateKey, 'sha256');

    return $headerEncoded . '.' . $payloadEncoded . '.' . base64UrlEncode($signature);
}

function getAccessToken($jwt) {
    $url = 'https://oauth2.googleapis.com/token';

    $data = [
        'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
        'assertion' => $jwt,
    ];

    $options = [
        'http' => [
            'header'  => 'Content-Type: application/x-www-form-urlencoded',
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        die('Error fetching access token');
    }

    $response = json_decode($result, true);
    return $response['access_token'];
}

// Load your service account credentials from the JSON file
$serviceAccount = json_decode(file_get_contents('/home/vol1_8/infinityfree.com/if0_37134249/htdocs/your-service-account-file.json'), true); // Update the path to your service account file

// Extract the required fields
$clientEmail = $serviceAccount['client_email'];
$privateKey = $serviceAccount['private_key'];
$projectId = $serviceAccount['project_id'];

// Create the JWT
$jwt = createJWT($clientEmail, $privateKey, $projectId);

// Get the access token
$accessToken = getAccessToken($jwt);

if ($accessToken) {
    echo $accessToken;
} else {
    echo 'Failed to fetch access token.';
}

?>
