<?php

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
$columnNames = Sheet::getColumnNames($sheet);

// Para cada linha, vamos pegar os dados que queremos
Sheet::lineEach($sheet, function ($row) use ($sheet, $columnNames) {
    // Inicializamos a função que vai buscar os valores passando os valores iniciais
    // $cellGetter é uma função que só precisa receber o nome da coluna
    $cellGetter = Sheet::cellGetter($sheet, $row, $columnNames);

    // Usamos $cellGetter para obter os valores
    $corretor = $cellGetter('corretor');
    echo $corretor;
});