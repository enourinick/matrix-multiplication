<?php

namespace App\Services;

class ToExcelColumnNameConverterService
{
    /**
     * This function will return excel column name by the given number.
     *
     * @param int $columnNumber
     * @return string
     */
    public function getExcelColumnName(int $columnNumber): string
    {
        if ($columnNumber < 1) {
            return (string)$columnNumber;
        }

        $dividend = $columnNumber;
        $columnName = '';

        while ($dividend > 0) {
            $modulo = ($dividend - 1) % 26;
            $columnName = chr(65 + $modulo) . $columnName;
            $dividend = (int)(($dividend - $modulo) / 26);
        }

        return $columnName;
    }

    /**
     * Conver a numeric vector.
     *
     * @param array $row
     * @return array
     */
    public function convertVector(array $row): array
    {
        return array_map([$this, 'getExcelColumnName'], $row);
    }

    /**
     * Convert a numeric matrix.
     *
     * @param array $matrix
     * @return array
     */
    public function convertMatrix(array $matrix): array
    {
        return array_map([$this, 'convertVector'], $matrix);
    }
}
