<?php
declare(strict_types=1);

namespace Pfazzi\ML\Test;

use Pfazzi\ML\Math\Vector;
use PHPUnit\Framework\TestCase;

class VectorTest extends TestCase
{
    function testCreation(): void
    {
        $vector = Vector::fromValues(1, 2, 3, 4, 5);

        self::assertEquals(3, $vector->getAt(3));
        self::assertEquals(3, $vector[3]);
    }
}