<?php
declare(strict_types=1);

namespace Pfazzi\ML\Test;

use Pfazzi\ML\Dataset;
use Pfazzi\ML\LinearRegression;
use Pfazzi\ML\Math;
use Pfazzi\ML\Reader;
use PHPUnit\Framework\TestCase;

class LinearRegressionTest extends TestCase
{
    public function test_it_predicts_output(): void
    {
        $data = Reader::readCsv(__DIR__ . '/../resources/housing.data', '/\s+/');

        self::assertIsArray($data);
        self::assertCount(506, $data);

        $firstLine = $data[0];
        self::assertIsArray($firstLine);
        self::assertCount(14, $firstLine);
        self::assertEquals(2.180, $data[4][2]);

        $names = ["CRIM","ZN","INDUS","CHAS","NOX","RM","AGE","DIS","RAD","TAX","PRATIO","B","LSTAT","MEDV"];

        $x = Dataset::extractColumn($names, 'RM', $data);
        self::assertEquals(7.1850, $x[2]);

        $y = Dataset::extractColumn($names, 'MEDV', $data);

        [$xTrain, $xTest, $yTrain, $yTest] = Dataset::split($x, $y, 0.3, false);
        $expectedCount = intval(506 * 0.3);
        self::assertEquals(506, count($xTrain) + count($xTest));
        self::assertCount(506 - $expectedCount, $xTrain);
        self::assertCount(506 - $expectedCount, $yTrain);
        self::assertCount($expectedCount, $xTest);
        self::assertCount($expectedCount, $yTest);
        self::assertNotEquals($xTest, array_intersect_key($xTrain, $xTest));
        self::assertNotEquals($yTest, array_intersect_key($yTrain, $yTest));

        $lr = new LinearRegression();
        $lr->train($xTrain, $yTrain);
        $yPredTrain = $lr->predict($xTrain);
        $yPredTest = $lr->predict($xTest);

        self::assertEquals(57.871584007423, Math::meanSquaredError($yTrain, $yPredTrain));
        self::assertEquals(10.098493541328, Math::meanSquaredError($yTest, $yPredTest));
    }
}
