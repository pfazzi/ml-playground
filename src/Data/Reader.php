<?php
declare(strict_types=1);

namespace Pfazzi\ML\Data;

use Pfazzi\ML\Math\Matrix;
use Pfazzi\ML\Math\Vector;

class Reader
{
    public static function readCsv(string $filename, string $separatorPattern): Matrix
    {
        $lines = file_get_contents($filename);
        $lines = trim($lines);
        $lines = explode("\n", $lines);
        $lines = array_map(fn (string $line): array => preg_split($separatorPattern, trim($line)), $lines);
        $lines = array_map(fn (array $line): array => array_map('floatval', $line), $lines);
        $lines = array_map(fn (array $line): Vector => Vector::fromValues(...$line), $lines);

        return Matrix::fromRows(...$lines);
    }
}