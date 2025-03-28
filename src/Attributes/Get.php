<?php

declare(strict_types=1);

namespace src\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Get extends Route
{
    public function __construct(string $routePath)
    {
        parent::__construct($routePath, 'get');
    }

}