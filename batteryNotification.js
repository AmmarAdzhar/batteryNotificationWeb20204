<?php
$token = "f2VoLxguR668dmMfKOg55e:APA91bE6Co6vx6qFsXcWko1fqhUHPY5lTkx1aSHv__MOvKaJoqLRxo-raMzyJrA3N-PNPSfI68Fq6MzxHsevKj2wKApPNNJp7yhqCdIJjryhxipp8an-O_5xYN0yhOQF7wuP1NnGMq-m";
$message = array(
    "message" => "Battery level is above 20%",
    "title" => "Battery Notification",
);

$payload = array(
    "to" => $token,
    "notification" => $message,
    "priority" => "high"
);

$headers = array(
    "Authorization: key=YOUR_SERVER_KEY",
    "Content-Type: application/json"
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
$result = curl_exec($ch);
curl_close($ch);

echo $result;
