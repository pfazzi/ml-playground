<?php
declare(strict_types=1);

namespace Pfazzi\ML\Math;

/**
 * @param Vector|array ...$rows
 */
function m(...$rows): Matrix
{
    if ($rows[0] instanceof Vector) {
        return Matrix::fromRows(...$rows);
    }

    return Matrix::fromArray($rows);
}

function v(float ...$values): Vector
{
    return Vector::fromValues(...$values);
}