<?php
declare(strict_types=1);

namespace Pfazzi\ML;

class Math
{
    public static function meanSquaredError(array $observed, array $predicted): float
    {
        $lossFunction = fn (float $x, float $y): float => self::square($x - $y);

        $loss = array_map($lossFunction, $observed, $predicted);

        return array_sum($loss) / count($observed);
    }

    public static function variance(array $x): float
    {
        $mean = self::mean($x);

        return self::mean(array_map(fn (float $xi): float => self::square($xi - $mean), $x));
    }

    public static function covariance(array $x, array $y): float
    {
        $xMean = self::mean($x);
        $yMean = self::mean($y);

        $terms = array_map(
            fn (float $xi, float $yi): float => ($xi - $xMean) * ($yi - $yMean),
            $x,
            $y
        );

        return array_sum($terms) / count($x);
    }

    public static function mean(array $x): float
    {
        return array_sum($x) / count($x);
    }

    public static function square(float $x): float
    {
        return pow($x, 2);
    }
}