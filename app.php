<?php

use Avlima\PhpCpfCnpjGenerator\Generator;

require 'vendor/autoload.php';
require 'src/app/XLSXDriver.php';
require 'src/app/Sheet.php';

$driver = new XLSXDriver('./src/database.xlsx', 'principal');

echo $driver->getCellValue('codigo', 3);
echo "\n";

// ---

// Criamos a planilha
$sheet = Sheet::from('./src/database.xlsx', 'principal');
// Pegamos os nomes das colunas
// $columnNames = Sheet::getColumnNames($sheet);
$columnNames = include './src/assets/columns.php';

// Para cada linha, vamos pegar os dados que queremos
Sheet::lineEach($sheet, function ($row) use ($sheet, $columnNames) {
    // Inicializamos a função que vai buscar os valores passando os valores iniciais
    // $cellGetter é uma função que só precisa receber o nome da coluna
    $cellGetter = Sheet::cellGetter($sheet, $row, $columnNames);

    // Usamos $cellGetter para obter os valores
    $corretor = $cellGetter('corretor');
    echo $corretor;
});

// $curl = curl_init();

// curl_setopt_array($curl, [
//     CURLOPT_URL => '',
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 10,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'POST',
//     CURLOPT_POSTFIELDS => [
//         'campo da api' => 'valor a ser enviado',
//     ]
// ]);

// $response = curl_exec($curl);
// var_dump($response);

echo PHP_EOL;

// $newCpf = CPFGen::generate();
$newCPF = Generator::cpf();

print_r($newCPF);

echo PHP_EOL;