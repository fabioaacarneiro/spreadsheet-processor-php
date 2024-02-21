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

        foreach ($sheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $columns[$cell->getValue()] = $cell->getColumn();
            }

            break;
        }
        return $columns;
    }

    public static function lineEach(Worksheet $sheet, $callback)
    {
        foreach ($sheet->getRowIterator() as $row) {
            if ($row->getRowIndex() == 1) {
                continue;
            }

            $callback($row);
        }
    }

    public static function cellGetter(Worksheet $sheet, Row $row, array $columns)
    {
        return function ($name) use ($row, $columns, $sheet) {
            return $sheet->getCell($columns[$name] . $row->getRowIndex())->getValue();
        };
    }
}