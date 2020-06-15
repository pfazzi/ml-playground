<?php
declare(strict_types=1);

namespace Pfazzi\ML\Test;

use Pfazzi\ML\Algorithm\LinearRegression;
use Pfazzi\ML\Data\Dataset;
use Pfazzi\ML\Data\Names;
use Pfazzi\ML\Data\Reader;
use Pfazzi\ML\Math\VectorFunctions;
use PHPUnit\Framework\TestCase;

class GradientDescentTest extends TestCase
{
    private Dataset $dataset;

    protected function setUp(): void
    {
        $names = Names::fromValues("CRIM","ZN","INDUS","CHAS","NOX","RM","AGE","DIS","RAD","TAX","PRATIO","B","LSTAT","MEDV");
        $data = Reader::readCsv(__DIR__ . '/../resources/housing.data', '/\s+/');

        $this->dataset = Dataset::new($names, $data);
    }

    public function testGradientDescent(): void
    {
        $x = $this->dataset->column('RM');
        $y = $this->dataset->column('MEDV');

        [$xTrain, $xTest, $yTrain, $yTest] = Dataset::split($x, $y, 0.3, false);

        $lr = new LinearRegression();
        $lr->trainWithGradientDescent($xTrain, $yTrain, 0.001, 100);
        $yPredTrain = $lr->predict($xTrain);
        $yPredTest = $lr->predict($xTest);

        self::assertEquals(57.871584007423, VectorFunctions::meanSquaredError($yTrain, $yPredTrain));
        self::assertEquals(10.098493541328, VectorFunctions::meanSquaredError($yTest, $yPredTest));
    }
}