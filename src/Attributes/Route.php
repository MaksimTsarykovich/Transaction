<?php

declare(strict_types=1);

namespace src\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    public function __construct
    (
        public string $routePath,
        public string $method,
    )
    {
    }
}