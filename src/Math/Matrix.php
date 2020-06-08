<?php
declare(strict_types=1);

namespace Pfazzi\ML\Math;

use Webmozart\Assert\Assert;

class Matrix implements \ArrayAccess
{
    /**
     * @var Vector[]
     */
    private array $rows;

    private int $columnCount;

    private function __construct(Vector ...$rows)
    {
        $this->columnCount = count($rows[0]);

        Assert::allCount($rows, $this->columnCount);

        $this->rows = $rows;
    }

    /**
     * @param float[][] $array
     */
    public static function fromArray(array $array): self
    {
        return self::fromRows(...array_map(
            fn (array $row): Vector => Vector::fromValues(...$row),
            $array
        ));
    }

    public static function fromRows(Vector ...$vectors): self
    {
        return new self(...$vectors);
    }

    public function get(int $row, int $column): float
    {
        return $this->rows[--$row]->getAt($column);
    }

    public function getRow(int $row): Vector
    {
        return $this->rows[--$row];
    }

    public function offsetExists($offset)
    {
        throw new \LogicException('Not implemented yet');
    }

    public function offsetGet($offset)
    {
        Assert::integer($offset);

        return $this->getRow($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new \LogicException('Not implemented yet');
    }

    public function offsetUnset($offset)
    {
        throw new \LogicException('Not implemented yet');
    }

    public function multiplyBy(int $a): Matrix
    {
        return $this->map(fn (Vector $row): Vector => $row->multiplyBy($a));
    }

    /**
     * @param callable(Vector):Vector $f
     */
    private function map(callable $f): Matrix
    {
        /** @psalm-var Vector[] $vectors */
        $vectors = array_map($f, $this->rows);

        Assert::allIsInstanceOf($vectors, Vector::class);

        return Matrix::fromRows(...$vectors);
    }

    public function rowCount(): int
    {
        return \count($this->rows);
    }

    public function column(int $index): Vector
    {
        $values = array_map(
            fn (Vector $row): float => $row->getAt($index),
            $this->rows
        );

        return Vector::fromValues(...$values);
    }

    public function columnCount(): int 
    {
        return $this->columnCount;
    }

    /**
     * @return Vector[]
     */
    public function columns(): array
    {
        return array_map(
            fn (int $index): Vector => $this->column($index),
            range(1, $this->columnCount())
        );
    }

    public function transpose(): self
    {
        return self::fromRows(...$this->columns());
    }
}