<?php

namespace App;

use Dotenv\Dotenv;

abstract class Request
{
    static public function sendRequestToImoview(array $body)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "\..\..\.env");
        $dotenv->load();

        $url = $_ENV["URL_API"];
        $key = $_ENV["KEY_API"];

        $jsonEncodedBodyRequest = json_encode($body, JSON_UNESCAPED_UNICODE);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonEncodedBodyRequest);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "chave: $key"
        ]);

        var_dump(curl_exec(json_decode($curl, JSON_PRETTY_PRINT)));
    }

}
