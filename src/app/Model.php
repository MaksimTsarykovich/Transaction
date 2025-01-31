<?php

declare(strict_types=1);

namespace App;

abstract class Model
{
    protected DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }
}