<?php
declare(strict_types=1);

namespace Pfazzi\ML\Algorithm;

use Pfazzi\ML\Math\VectorFunctions;
use Pfazzi\ML\Math\Vector;

class LinearRegression
{
    private float $intercept = 0;
    private float $slope = 0;

    public function predict(Vector $x): Vector
    {
        return $x->map(fn (float $sample): float => $this->predictOne($sample));
    }

    public function predictOne(float $x): float
    {
        return $this->intercept + $this->slope * $x;
    }

    public function train(Vector $x, Vector $y): void
    {
        $this->slope = VectorFunctions::covariance($x, $y) / VectorFunctions::variance($x);

        $this->intercept = VectorFunctions::mean($y) - $this->slope * VectorFunctions::mean($x);
    }

    public function trainWithGradientDescent(Vector $x, Vector $y, float $alpha, int $epochs)
    {
        $this->slope = rand(1, 10);
        $this->intercept= rand(1, 10);

        for ($epoch = 0; $epoch < $epochs; $epoch++) {
            $this->updateParams($x, $y, $alpha);
        }
    }

    private function updateParams(Vector $x, Vector $y, float $alpha): void
    {
        $deltaSlope = 0.0;
        $DeltaIntercept = 0.0;

        $n = $x->count();

        for ($i = 1; $i <= $n; $i++) {
            $deltaSlope += -2 * $x[$i] * ($y[$i] - ($this->slope * $x[$i] + $this->intercept));
            $DeltaIntercept += -2 * ($y[$i] - ($this->slope * $x[$i] + $this->intercept));
        }

        $this->slope -= (1/$n) * $deltaSlope * $alpha;
        $this->intercept -= (1/$n) * $DeltaIntercept * $alpha;
    }
}