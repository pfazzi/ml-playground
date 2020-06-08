<?php
declare(strict_types=1);

namespace Pfazzi\ML\Test;

use Pfazzi\ML\Math\Matrix;
use PHPUnit\Framework\TestCase;
use function Pfazzi\ML\Math\m;
use function Pfazzi\ML\Math\v;

class MathFunctionsTest extends TestCase
{
    function testMatrixCreation(): void
    {
        $matrix = m(
            v(1, 2, 3, 4, 5),
            v(6, 7, 8, 9, 10),
        );

        $expected = Matrix::fromArray([
            [1, 2, 3, 4, 5],
            [6, 7, 8, 9, 10],
        ]);

        self::assertEquals($expected, $matrix);
    }

    function testMatrixCreationFromArray(): void
    {
        $matrix = m(
            [1, 2, 3, 4, 5],
            [6, 7, 8, 9, 10],
        );

        $expected = Matrix::fromArray([
            [1, 2, 3, 4, 5],
            [6, 7, 8, 9, 10],
        ]);

        self::assertEquals($expected, $matrix);
    }
}