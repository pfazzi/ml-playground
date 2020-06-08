<?php
declare(strict_types=1);

namespace Pfazzi\ML\Algorithm;

use Pfazzi\ML\Math\VectorFunctions;
use Pfazzi\ML\Math\Vector;

class LinearRegression
{
    private float $intercept = 0;
    private float $slope = 0;

    public function train(Vector $x, Vector $y): void
    {
        $this->slope = VectorFunctions::covariance($x, $y) / VectorFunctions::variance($x);

        $this->intercept = VectorFunctions::mean($y) - $this->slope * VectorFunctions::mean($x);
    }

    public function predict(Vector $x): Vector
    {
        return $x->map(fn (float $sample): float => $this->predictOne($sample));
    }

    public function predictOne(float $x): float
    {
        return $this->intercept + $this->slope * $x;
    }
}