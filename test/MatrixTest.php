<?php
declare(strict_types=1);

namespace Pfazzi\ML\Test;

use Pfazzi\ML\Math\Matrix;
use Pfazzi\ML\Math\Vector;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    function testCreationFromVectors()
    {
        $matrix = Matrix::fromRows(
            Vector::fromValues(11, 12, 13, 14, 15),
            Vector::fromValues(21, 22, 23, 24, 25),
        );

        self::assertEquals(23, $matrix->get(2, 3));
        self::assertEquals(23, $matrix[2][3]);
    }

    function testMultiplyBySingleNumber(): void
    {
        $matrix = Matrix::fromRows(
            Vector::fromValues(11, 12, 13, 14, 15),
            Vector::fromValues(21, 22, 23, 24, 25),
        );

        $result = $matrix->multiplyBy(4);

        self::assertEquals(Matrix::fromRows(
            Vector::fromValues(4 * 11, 4 * 12, 4 * 13, 4 * 14, 4 * 15),
            Vector::fromValues(4 * 21, 4 * 22, 4 * 23, 4 * 24, 4 * 25),
        ), $result);
    }

    function testTraspose(): void
    {
        $matrix = Matrix::fromArray([
            [1, 3, 5],
            [2, 4, 6],
        ]);

        $transposed = $matrix->transpose();

        self::assertEquals(Matrix::fromArray([
            [1, 2],
            [3, 4],
            [5, 6],
        ]), $transposed);
    }
}