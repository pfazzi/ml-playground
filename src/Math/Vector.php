<?php
declare(strict_types=1);

namespace Pfazzi\ML\Math;

use Webmozart\Assert\Assert;

class Vector implements \ArrayAccess, \Countable
{
    /**
     * @var float[]
     */
    private array $values;

    private int $count;

    private function __construct(float ...$values)
    {
        $this->values = $values;
        $this->count = \count($values);
    }

    public static function fromValues(float ...$values): self
    {
        return new self(...$values);
    }

    public function getAt(int $index): float
    {
        return $this->values[--$index];
    }

    public function offsetExists($offset)
    {
        throw new \LogicException('Not implemented yet');
    }

    public function offsetGet($offset)
    {
        return is_int($offset) ? $this->getAt($offset) : null;
    }

    public function offsetSet($offset, $value)
    {
        throw new \LogicException('Not implemented yet');
    }

    public function offsetUnset($offset)
    {
        throw new \LogicException('Not implemented yet');
    }

    /**
     * @return float[]
     */
    public function toArray(): array
    {
        return $this->values;
    }

    public function count(): int
    {
        return $this->count;
    }

    /**
     * @psalm-param callable(float):float $f
     */
    public function map(callable $f): Vector
    {
        /** @psalm-var float[] $values */
        $values = array_map($f, $this->values);

        Assert::allFloat($values);

        return Vector::fromValues(...$values);
    }

    public function multiplyBy(int $a): Vector
    {
        return $this->map(fn (float $x): float => $a * $x);
    }

    public function mean(): float
    {
        return $this->sum() / $this->count();
    }

    public function sum(): float
    {
        return array_sum($this->values);
    }
}