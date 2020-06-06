<?php
declare(strict_types=1);

namespace Pfazzi\ML;

use Webmozart\Assert\Assert;

class Dataset
{
    /**
     * @param string[] $names
     * @param array<int, array<int, mixed>> $dataset
     *
     * @return array<int, mixed>
     */
    public static function extractColumn(array $names, string $name, array $dataset): array
    {
        $roomNumberColumn = array_search($name, $names);

        $retval = array_column($dataset, $roomNumberColumn);

        return $retval;
    }

    /**
     * @param array<int, array<int, mixed>> $x
     * @param array<int, array<int, mixed>> $y
     *
     * @return array<int, array<int, array<int, mixed>>>
     */
    public static function split(array $x, array $y, float $testSize, bool $shuffle = true): array
    {
        Assert::range($testSize, 0, 1);

        $keys = array_keys($x);
        $itemCount = count($keys);

        if ($shuffle) {
            shuffle($keys);
        }

        $testItemCount = (int) ($itemCount * $testSize);
        $testKeys = array_flip(array_slice($keys, 0, $testItemCount));
        $trainKeys = array_flip(array_slice($keys, $testItemCount));

        $valuesFromKeys = fn (array $keys, array $values): array =>
            array_values(array_intersect_key($values, $keys));

        $xTrain = $valuesFromKeys($trainKeys, $x);
        $xTest = $valuesFromKeys($testKeys, $x);
        $yTrain = $valuesFromKeys($trainKeys, $y);
        $yTest = $valuesFromKeys($testKeys, $y);

        return [$xTrain, $xTest, $yTrain, $yTest];
    }
}