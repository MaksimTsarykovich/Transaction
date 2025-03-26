<?php

declare(strict_types=1);

namespace Infrastructure\Http;

class Request
{
    private array $get;
    private array $post;
    private array $cookies;
    private array $files;
    private array $server;
    private ?string $rawContent = null;

    public function __construct()
    {
        $this->get = $_GET ?? [];
        $this->post = $_POST ?? [];
        $this->cookies = $_COOKIE ?? [];
        $this->files = $_FILES ?? [];
        $this->server = $_SERVER ?? [];
    }

    public function get(string $key = null, $default = null): mixed
    {
        if ($key == null) {
            return $this->get;
        }

        return $this->get[$key] ?? $default;
    }

    public function post(string $key = null, $default = null): mixed
    {
        if ($key == null) {
            return $this->post;
        }

        return $this->post[$key] ?? $default;
    }

    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    public function files(): ?array
    {
        return $this->files ?? null;
    }

}