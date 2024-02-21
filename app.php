<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';
require 'src/app/XLSXDriver.php';
require 'src/app/Sheet.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// var_dump(getenv("URL_API"));

$sheet = Sheet::from('./src/database/database.xlsx', 'principal');
$columnNames = Sheet::getColumnNames($sheet);

function currencyToInteger($stringCurrency): int
{
    $number = preg_replace('/[^0-9,.]/', '', $stringCurrency);
    $number = str_replace(',', '', $number);
    $number = (int) $number;
    return $number;
}

// Para cada linha, vamos pegar os dados que queremos
Sheet::lineEach($sheet, function ($row) use ($sheet, $columnNames) {

    $cellGetter = Sheet::cellGetter($sheet, $row, $columnNames);

    $requestBody = [
        "codigousuario" => $_ENV["USER_CODE"],
        "codigounidade" => $_ENV["UNIT_CODE"],
        "finalidade" => $cellGetter("codigofinalidade"),
        "destinacao" => $cellGetter("codigodestinacao"),
        "codigotipo" => $cellGetter("tipoimovel"),
        "localchave" => $cellGetter("codigolocalchave"),
        "valores" => [
            "valor" => currencyToInteger($cellGetter("valor")),
        ],
        "endereco" => [
            "rua" => $cellGetter("endereco"),
            "bairro" => $cellGetter("bairro"),
            "cidade" => $cellGetter("cidade"),
            "estado" => $cellGetter("estado"),
        ],
        "proprietarios" => [
            [
                "nome" => $cellGetter("proprietario"),
                "telefone" => $cellGetter("telefoneproprietario"),
                "email" => $cellGetter("emailproprietario"),
                "percentual" => 100
            ]
        ],
        "descricao" => "Inclusão dos imóveis da Fabi"
    ];

    print_r(json_encode($requestBody, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    echo PHP_EOL;
});
