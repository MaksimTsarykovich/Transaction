<?php

declare(strict_types=1);

namespace Attributes;

use Attribute;
use src\Attributes\Route;

#[Attribute(Attribute::TARGET_METHOD)]
class Put extends Route
{
    public function __construct(string $routePath)
    {
        parent::__construct($routePath, 'put');
    }

}