<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use Pfazzi\ML\Data\Dataset;
use Pfazzi\ML\Algorithm\LinearRegression;
use Pfazzi\ML\Math\VectorFunctions;
use Pfazzi\ML\Data\Names;
use Pfazzi\ML\Data\Reader;

$names = Names::fromValues("CRIM","ZN","INDUS","CHAS","NOX","RM","AGE","DIS","RAD","TAX","PRATIO","B","LSTAT","MEDV");
$data = Reader::readCsv(__DIR__ . '/../resources/housing.data', '/\s+/');

$dataset = Dataset::new($names, $data);

$x = $dataset->column('RM');
$y = $dataset->column('MEDV');

[$xTrain, $xTest, $yTrain, $yTest] = Dataset::split($x, $y, 0.3);

$lr = new LinearRegression();
$lr->train($xTrain, $yTrain);
$yPredTrain = $lr->predict($xTrain);
$yPredTest = $lr->predict($xTest);

printf("MSE train: %f\n", VectorFunctions::meanSquaredError($yTrain, $yPredTrain));
printf("MSE test: %f\n", VectorFunctions::meanSquaredError($yTest, $yPredTest));