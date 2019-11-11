<?php

namespace App\Services;

class MultiplyService
{
    public function multiply(array $matrix1, array $matrix2): array
    {
        $result = [];

        for ($i = 0; $i < count($matrix1); $i++) {
            for ($j = 0; $j < count($matrix2[0]); $j++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < count($matrix2); $k++) {
                    $result[$i][$j] += $matrix1[$i][$k] * $matrix2[$k][$j];
                }
            }
        }

        return $result;
    }
}
