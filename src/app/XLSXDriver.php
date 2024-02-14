<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

require 'Helper.php';

class XLSXDriver
{

    private $sheet;

    public function __construct(string $fileName, string $sheetName)
    {
        $spreadsheet = IOFactory::load($fileName);
        $this->sheet = $spreadsheet->getSheetByName($sheetName);
    }

    public function getLine(int $linenum): array
    {
        $requestedRow = [];

        for ($i = 0; $i < 9999; $i++) {
            try {
                $currentCell = $this->sheet->getCell([$i, $linenum])->getValue();
                if (is_null($currentCell)) {
                    break;
                } else {
                    array_push($requestedRow, $currentCell);
                }
            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
                echo $e->getMessage();
            }
        }

        return $requestedRow;
    }

    public function getCellValue(string $colName, int $row)
    {
        global $getColumnLetter;

        $col = $getColumnLetter($colName);

        try {
            $currentCell = $this->sheet->getCell($col . $row)->getValue();
            if (is_null($currentCell)) {
                return "";
            } else {
                return $currentCell;
            }
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            echo $e->getMessage();
        }
    }

}