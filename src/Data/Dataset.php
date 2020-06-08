<?php
declare(strict_types=1);

namespace Pfazzi\ML\Data;

use Pfazzi\ML\Math\Matrix;
use Pfazzi\ML\Math\Vector;
use Pfazzi\ML\Data\Names;
use Webmozart\Assert\Assert;

class Dataset
{
    private Names $names;
    private Matrix $data;

    private function __construct(Names $names, Matrix $data)
    {
        $this->names = $names;
        $this->data = $data;
    }

    public function column(string $name): Vector
    {
        return $this->data->column($this->names->indexOf($name));
    }

    /**
     * @return Vector[]
     */
    public static function split(Vector $x, Vector $y, float $testSize, bool $shuffle = true): array
    {
        $x = $x->toArray();
        $y = $y->toArray();

        Assert::range($testSize, 0, 1);

        $keys = array_keys($x);
        $itemCount = count($keys);

        if ($shuffle) {
            shuffle($keys);
        }

        $testItemCount = (int) ($itemCount * $testSize);
        $testKeys = array_flip(array_slice($keys, 0, $testItemCount));
        $trainKeys = array_flip(array_slice($keys, $testItemCount));

        /** @psalm-var callable(int[], float[]):float[] $valuesFromKeys */
        $valuesFromKeys = fn (array $keys, array $values): array =>
            array_values(array_intersect_key($values, $keys));

        $xTrain = $valuesFromKeys($trainKeys, $x);
        $xTest = $valuesFromKeys($testKeys, $x);
        $yTrain = $valuesFromKeys($trainKeys, $y);
        $yTest = $valuesFromKeys($testKeys, $y);

        return [
            Vector::fromValues(...$xTrain),
            Vector::fromValues(...$xTest),
            Vector::fromValues(...$yTrain),
            Vector::fromValues(...$yTest)
        ];
    }

    public static function new(Names $names, Matrix $data): self
    {
        Assert::eq(
            $names->count(),
            $data->columnCount()
        );

        return new self($names, $data);
    }
}