<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';

use Pfazzi\ML\Dataset;
use Pfazzi\ML\LinearRegression;
use Pfazzi\ML\Math;
use Pfazzi\ML\Reader;

$names = ["CRIM","ZN","INDUS","CHAS","NOX","RM","AGE","DIS","RAD","TAX","PRATIO","B","LSTAT","MEDV"];
$data = Reader::readCsv(__DIR__ . '/../resources/housing.data', '/\s+/');

$x = Dataset::extractColumn($names, 'RM', $data);
$y = Dataset::extractColumn($names, 'MEDV', $data);

[$xTrain, $xTest, $yTrain, $yTest] = Dataset::split($x, $y, 0.3);

$lr = new LinearRegression();
$lr->train($xTrain, $yTrain);
$yPredTrain = $lr->predict($xTrain);
$yPredTest = $lr->predict($xTest);

printf("MSE train: %f\n", Math::meanSquaredError($yTrain, $yPredTrain));
printf("MSE test: %f\n", Math::meanSquaredError($yTest, $yPredTest));