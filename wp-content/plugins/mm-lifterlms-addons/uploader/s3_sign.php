<?php

$AWS_SECRET_ACCESS_KEY = '';
$AWS_REGION = '';

//the data is correct here use them
$to_sign = $_GET["to_sign"];
$dateTime = $_GET["datetime"];

//format the datetime to the correct format AWS expect
$dt = new DateTime($dateTime);
$formattedDate = $dt->format('Ymd');
//make the Signature, notice that we use env for saving AWS keys and regions

$kSecret = "AWS4" . $AWS_SECRET_ACCESS_KEY;
$kDate = hash_hmac("sha256", $formattedDate, $kSecret, true);
$kRegion = hash_hmac("sha256", $AWS_REGION, $kDate, true);
$kService = hash_hmac("sha256", 's3', $kRegion, true);
$kSigning = hash_hmac("sha256", "aws4_request", $kService, true);
$signature = hash_hmac("sha256", $to_sign, $kSigning);
// return response()->json(["success"=>true, "signature"=>$signature]);
//let's just return plain text
echo $signature;

?>
