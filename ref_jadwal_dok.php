<?php
require_once 'conf.php';

$response = $client->request('GET', 'jadwaldokter/kodepoli/INT/tanggal/2022-11-03', [
    'headers' => getSignature()
]);
$kunci = getKey();

$en = json_decode($response->getBody()->getContents());
$es = decompress(stringDecrypt($kunci, $en->response));
print_r($es);

?>