<?php

declare(strict_types=1);

namespace Infrastructure\Http;


class Response
{
    public function status(int $code):self
    {
        http_response_code($code);
        return $this;
    }

    public function header(string $name, string $value):self
    {
        header("$name: $value");
        return $this;
    }

    public function redirect(string $url, int $code = 302): never
    {
        $this->status($code);
        header("Location: $url");
        exit;
    }
}