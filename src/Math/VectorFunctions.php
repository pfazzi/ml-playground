<?php
declare(strict_types=1);

namespace Pfazzi\ML\Math;

class VectorFunctions
{
    public static function meanSquaredError(Vector $observed, Vector $predicted): float
    {
        $lossFunction = fn (float $x, float $y): float => ($x - $y) ** 2;

        $loss = array_map($lossFunction, $observed->toArray(), $predicted->toArray());

        return array_sum($loss) / count($observed);
    }

    public static function variance(Vector $x): float
    {
        $mean = self::mean($x);

        return self::mean($x->map(fn (float $xi): float => ($xi - $mean) ** 2));
    }

    public static function covariance(Vector $x, Vector $y): float
    {
        $xMean = self::mean($x);
        $yMean = self::mean($y);

        $terms = array_map(
            fn (float $xi, float $yi): float => ($xi - $xMean) * ($yi - $yMean),
            $x->toArray(),
            $y->toArray()
        );

        return array_sum($terms) / count($x);
    }

    public static function mean(Vector $x): float
    {
        return array_sum($x->toArray()) / count($x);
    }
}