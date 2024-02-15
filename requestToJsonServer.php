<?php

$arryDATA = [
    "id" => "2",
    "title" => "another task"
];

$jsonDATA = json_encode($arryDATA);

$curlPOST = curl_init();

curl_setopt($curlPOST, CURLOPT_URL, "http://localhost:3000/posts");
curl_setopt($curlPOST, CURLOPT_POSTFIELDS, $jsonDATA);
curl_setopt($curlPOST, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlPOST, CURLOPT_HTTPHEADER, [
    "Contente-Type: application/json",
    "Content-length: " . strlen($jsonDATA),
]);

$responsePOST = json_decode(curl_exec($curlPOST));

echo "antes do POST\n";
print_r($responsePOST);
echo "\ndepois do POST\n";

$curlGET = curl_init();
curl_setopt($curlGET, CURLOPT_URL, "http://localhost:3000/posts");
curl_setopt($curlGET, CURLOPT_RETURNTRANSFER, true);
$responseGET = json_decode(curl_exec($curlGET));

echo "\nantes do GET\n";
print_r($responseGET);
echo "\ndepois do GET\n";

