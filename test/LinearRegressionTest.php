<?php
declare(strict_types=1);

namespace Pfazzi\ML\Test;

use Pfazzi\ML\Data\Dataset;
use Pfazzi\ML\Algorithm\LinearRegression;
use Pfazzi\ML\Math\VectorFunctions;
use Pfazzi\ML\Data\Names;
use Pfazzi\ML\Data\Reader;
use PHPUnit\Framework\TestCase;

class LinearRegressionTest extends TestCase
{
    public function test_it_predicts_output(): void
    {
        $names = Names::fromValues("CRIM","ZN","INDUS","CHAS","NOX","RM","AGE","DIS","RAD","TAX","PRATIO","B","LSTAT","MEDV");
        $data = Reader::readCsv(__DIR__ . '/../resources/housing.data', '/\s+/');

        self::assertEquals(506, $data->rowCount());

        $firstLine = $data->getRow(1);
        self::assertCount(14, $firstLine);
        self::assertEquals(2.180, $data[5][3]);

        $dataset = Dataset::new($names, $data);

        $x = $dataset->column('RM');
        self::assertEquals(7.1850, $x[3]);

        $y = $dataset->column('MEDV');

        [$xTrain, $xTest, $yTrain, $yTest] = Dataset::split($x, $y, 0.3, false);
        $expectedCount = intval(506 * 0.3);
        self::assertEquals(506, count($xTrain) + count($xTest));
        self::assertCount(506 - $expectedCount, $xTrain);
        self::assertCount(506 - $expectedCount, $yTrain);
        self::assertCount($expectedCount, $xTest);
        self::assertCount($expectedCount, $yTest);

        $lr = new LinearRegression();
        $lr->train($xTrain, $yTrain);
        $yPredTrain = $lr->predict($xTrain);
        $yPredTest = $lr->predict($xTest);

        self::assertEquals(57.871584007423, VectorFunctions::meanSquaredError($yTrain, $yPredTrain));
        self::assertEquals(10.098493541328, VectorFunctions::meanSquaredError($yTest, $yPredTest));
    }
}
