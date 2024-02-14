<?php
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;

abstract class Sheet
{
    public static function from(string $file, string $sheet): Worksheet
    {
        $spreadsheet = IOFactory::load($file);
        return $spreadsheet->getSheetByName($sheet);
    }

    public static function getColumnNames(Worksheet $sheet): array
    {
        $columns = [];

        // Aqui a gente acessa apenas a primeira linha, onde tem os nomes das colunas
        // e colocamos os nomes das colunas na variável $columns no formato `nome => indice`
        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                // Aqui a gente faz o mapeamento, por exemplo, `$columns['codigo'] => 'C'
                $columns[$cell->getValue()] = $cell->getColumn();
            }

            // Não queremos iterar sobre outras linhas, apenas a primeira
            break;
        }
        return $columns;
    }

    public static function lineEach(Worksheet $sheet, $callback)
    {
        // Aqui a gente itera sobre todas as linhas, menos a primeira, pois ela só tem os nomes das colunas
        // Para cada linha a gente executa a função $callback
        foreach ($sheet->getRowIterator() as $row) {
            if ($row->getRowIndex() == 1) { // Pulando a primeira linha
                continue;
            }

            $callback($row);

            // Vou dar um break aqui para ele executar só uma vez para teste
            break;
        }
    }

    public static function cellGetter(Worksheet $sheet, Row $row, array $columns)
    {
        // A gente pega o conteúdo da coluna baseado no nome dela, para isso a gente recebe a planilha, linha e colunas primeiro
        // Retornamos uma função que só precisa receber o nome da coluna
        return function ($name) use ($row, $columns, $sheet) {
            // Pegamos o valor da célula pelas cordenadas
            // O índice da coluna pegamos do array de colunas que geramos em `getColumnNames`
            // O índice da linha pegamos de $row->getRowIndex()
            return $sheet->getCell($columns[$name] . $row->getRowIndex());
        };
    }
}