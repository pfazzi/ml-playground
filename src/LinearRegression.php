<?php
declare(strict_types=1);

namespace Pfazzi\ML;

/**
 * y = a + bx
 */
class LinearRegression
{
    private float $a = 0;
    private float $b = 0;

    public function train(array $x, array $y): void
    {
        $this->b = Math::covariance($x, $y) / Math::variance($x);

        $this->a = Math::mean($y) - $this->b * Math::mean($x);
    }

    public function predict(array $x): array
    {
        return array_map(
            fn (float $sample): float => $this->predictOne($sample),
            $x
        );
    }

    public function predictOne(float $x): float
    {
        return $this->a + $this->b * $x;
    }
}