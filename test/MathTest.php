<?php
declare(strict_types=1);

namespace Pfazzi\ML\Test;

use Pfazzi\ML\Math;
use PHPUnit\Framework\TestCase;

class MathTest extends TestCase
{
    function testVariance(): void
    {
        $variance = Math::variance([1, 2, 3, 4]);

        self::assertEquals(1.25, $variance);
    }

    function testCovariance(): void
    {
        $covariance = Math::covariance(
            [1, 2, 3],
            [10, 20, 27]
        );

        self::assertEquals(5.6666666666667, $covariance);
    }

    function testMean(): void
    {
        $mean = Math::mean([1, 2, 3, 4]);

        self::assertEquals(2.5, $mean);
    }

    function testMse(): void
    {
        $mse = Math::meanSquaredError(
            [34, 37, 44, 47, 48, 48, 46, 43, 32, 27, 26, 24],
            [37, 40, 46, 44, 46, 50, 45, 44, 34, 30, 22, 23]
        );

        self::assertEquals(5.9166666666667, $mse);
    }

}