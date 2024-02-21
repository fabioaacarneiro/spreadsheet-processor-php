<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';
require 'src/app/Sheet.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sheet = Sheet::from('./src/spreadsheet/database.xlsx', 'principal');
$columnNames = Sheet::getColumnNames($sheet);

function currencyToInteger(string $currency): int
{
    $number = str_replace(['.', ',00'], '', $currency);
    $number = preg_replace('/[^0-9.]/', '', $number);
    $number = (int) $number;
    return $number;
}

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
