<?php
require_once 'conf.php';

$id = $_GET['id'];

$timeStampData = microtime();
list($msec, $sec) = explode(' ', $timeStampData);
$msec = round($msec * 1000);
$result = $sec . $msec;

$waktu = $result - 3600000;

for ($i = 1; $i <= 5; $i++) {
    
    $response = $client->request('POST', 'antrean/updatewaktu', [
        'headers' => getSignature(),
        'json' => [
            "kodebooking" => $id,
            "taskid" => $i,
            "waktu" => $waktu
        ]
    ]);

    $waktu -= 900000;

    if ($i == 1) {
        break;
    };
    
}


$en = json_decode($response->getBody()->getContents());
print_r($en);
