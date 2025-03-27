<?php

declare(strict_types=1);

namespace src\Attributes;

use Attribute;

#[Attribute]
class Route
{
    public function __construct(
        public string $routePath,
        public string $method = 'get',
    )
    {
    }
}