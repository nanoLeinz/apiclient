<head>
    <script src="node_modules\sweetalert2\dist\sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<?php
require 'vendor/autoload.php';
require_once('lib.php');

use GuzzleHttp\Client;
date_default_timezone_set('UTC');

$dataid               = "29446";
$secretKey            = "2yM44573CA";
$tStamp               = strval(time() - strtotime('1970-01-01 00:00:00'));

$client = new GuzzleHttp\Client([
    'base_uri' => 'https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev/'
]);

function getSignature()
{
  global $dataid;
  global $secretKey;
  global $tStamp;

  $signature           = hash_hmac('sha256', $dataid . "&" . $tStamp, $secretKey, true);
  $encodedSignature    = base64_encode($signature);
  $urlencodedSignature = urlencode($encodedSignature);

  $header = [
    'x-cons-id' => $dataid,
    'x-timestamp' => $tStamp,
    'x-signature' => $encodedSignature,
    'user_key' => '9b8b83c9cb46e33e5383222b73c35c87',
    'Content-Type' => 'application/x-www-form-urlencoded'
  ];
  return $header;
}

function getKey()
{
  global $dataid;
  global $secretKey;
  global $tStamp;

  $key = $dataid . $secretKey . $tStamp;

  return $key;
};

function stringDecrypt($key, $string){
  $encrypt_method = 'AES-256-CBC';
  // hash
  $key_hash = hex2bin(hash('sha256', $key));
  // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
  $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
  $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
  return $output;
};

function decompress($string)
{
    return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
};

function test (){
global $client;
$response = $client->request('GET', 'ref/dokter', [
    'headers' => getSignature()
]);

$kunci = getKey();

$en = json_decode($response->getBody()->getContents());
$es = decompress(stringDecrypt($kunci, $en->response));
print_r($es);
};

function bukafetch($sql)
{
    //$conn = bukakoneksi();
    //print_r($sql);
    $database = new Database();
    $conn = $database->bukakoneksi();
    $result = sqlsrv_query($conn, $sql);
    if ($result === false) {
        echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
    };
    $hasil = sqlsrv_fetch_array($result);
    // var_dump($hasil);
    return $hasil;
};

function bukaquery2($sql)
{
    //$conn = bukakoneksi();
    GLOBAL $conn;
    $database = new Database();
    $conn = $database->bukakoneksi();
    $result = sqlsrv_query($conn, $sql);
    if ($result === false) {
        echo "Error (sqlsrv_query): " . print_r(sqlsrv_errors(), true);
    };
    //sqlsrv_close($conn);
    // $a = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    // var_dump($a);
    //var_dump($result);
    //sqlsrv_close($conn);
    return $result;
};

function pop($title, $icon, $text, $url) {
  echo "<script type='text/javascript'>
  $(document).ready(function() {
    Swal.fire({
          title: '$title',
          icon: '$icon',
          text: '$text',
          showDenyButton: false,
          showCancelButton: false,
          allowOutsideClick: false,
          confirmButtonText: 'OK',
      }).then((result) => {
          if (result.isConfirmed) {
              window.location.href = '$url';
                  }
              })
          });
      </script>";
   
};

?>