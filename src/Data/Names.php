<?php
declare(strict_types=1);

namespace Pfazzi\ML\Data;

use Webmozart\Assert\Assert;

class Names implements \ArrayAccess, \Countable
{
    /**
     * @var string[]
     */
    private array $names;

    private function __construct(string ...$values)
    {
        $this->names = $values;
    }

    public static function fromValues(string ...$values): self
    {
        return new self(...$values);
    }

    public function get(int $index): string
    {
        return $this->names[--$index];
    }

    public function offsetExists($offset)
    {
        throw new \LogicException('Not implemented yet');
    }

    public function offsetGet($offset)
    {
        Assert::integer($offset);

        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw new \LogicException('Not implemented yet');
    }

    public function offsetUnset($offset)
    {
        throw new \LogicException('Not implemented yet');
    }

    public function count()
    {
        return \count($this->names);
    }

    public function indexOf(string $name): int
    {
        $index = array_search($name, $this->names);

        Assert::integer($index);

        return $index + 1;
    }
}