<?php
declare(strict_types=1);

namespace Pfazzi\ML;

use Webmozart\Assert\Assert;

class Reader
{
    /**
     * @return array<int, array<int, mixed>>
     */
    public static function readCsv(string $filename, string $separatorPattern): array
    {
        $lines = file_get_contents($filename);
        $lines = trim($lines);
        $lines = explode("\n", $lines);
        $lines = array_map(fn (string $line): array => preg_split($separatorPattern, trim($line)), $lines);
        $lines = array_map(fn (array $line): array => array_map('floatval', $line), $lines);

        Assert::allIsArray($lines);

        return $lines;
    }
}