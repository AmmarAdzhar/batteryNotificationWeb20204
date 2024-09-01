<?php

function sendNotification($to, $title, $body, $accessToken) {
    $url = "https://fcm.googleapis.com/v1/projects/batterynotification2024/messages:send"; // Replace YOUR_PROJECT_ID with your actual project ID

    $message = [
        "message" => [
            "token" => $to,
            "notification" => [
                "title" => $title,
                "body" => $body
            ],
        ]
    ];

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($message));
    $result = curl_exec($ch);

    if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
    }

    curl_close($ch);
    return $result;
}

// Use the FCM token directly here for testing
$deviceToken = 'f2VoLxguR668dmMfKOg55e:APA91bE6Co6vx6qFsXcWko1fqhUHPY5lTkx1aSHv__MOvKaJoqLRxo-raMzyJrA3N-PNPSfI68Fq6MzxHsevKj2wKApPNNJp7yhqCdIJjryhxipp8an-O_5xYN0yhOQF7wuP1NnGMq-m';
$title = 'Low Battery Alert';
$body = 'Phone Vivo battery level is below 20%';

// Fetch access token from accessToken.php
$accessTokenUrl = 'http://batterynotification.infinityfreeapp.com/accessToken.php'; // Replace with actual URL
$accessToken = trim(file_get_contents($accessTokenUrl));

if (!$accessToken) {
    die('Failed to fetch access token.');
}

$response = sendNotification($deviceToken, $title, $body, $accessToken);
echo $response;

?>
