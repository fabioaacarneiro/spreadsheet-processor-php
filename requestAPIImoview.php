<?php

$chaveApi = "x2wGNb/MN+NSnynLyOcN8fHa4mxouBUj8g/bbTYPIDw=";
$publicKey = "chave";
$cnpj = "19.865.230/0001-41";
$userCode = 472;

$apiRoute = "https://api.imoview.com.br";

$urlsImoveiwGET = [
    "tipo" => "/Imovel/RetornarTiposImoveisDisponiveis",
    "finalidade" => "/Imovel/RetornarListaFinalidades",
    "destinacao" => "/Imovel/RetornarListaDestinacoes",
    "localchave" => "/Imovel/RetornarListaLocalChaves",
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $apiRoute . $urlsImoveiwGET["tipo"],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => [
        "chave: $chaveApi"
    ]
]);

$response = json_decode(curl_exec($curl));

// var_dump($response);
echo "\n";

foreach ($response as $data) {
    print_r($data);
}