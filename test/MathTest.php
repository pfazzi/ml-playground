<?php
declare(strict_types=1);

namespace Pfazzi\ML\Test;

use Pfazzi\ML\Math\VectorFunctions;
use Pfazzi\ML\Math\Vector;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    function testVariance(): void
    {
        $x = Vector::fromValues(1, 2, 3, 4);

        $variance = VectorFunctions::variance($x);

        self::assertEquals(1.25, $variance);
    }

    function testCovariance(): void
    {
        $covariance = VectorFunctions::covariance(
            Vector::fromValues(1, 2, 3),
            Vector::fromValues(10, 20, 27)
        );

        self::assertEquals(5.6666666666667, $covariance);
    }

    function testMean(): void
    {
        $mean = VectorFunctions::mean(Vector::fromValues(1, 2, 3, 4));

        self::assertEquals(2.5, $mean);
    }

    function testMse(): void
    {
        $mse = VectorFunctions::meanSquaredError(
            Vector::fromValues(34, 37, 44, 47, 48, 48, 46, 43, 32, 27, 26, 24),
            Vector::fromValues(37, 40, 46, 44, 46, 50, 45, 44, 34, 30, 22, 23)
        );

        self::assertEquals(5.9166666666667, $mse);
    }
}