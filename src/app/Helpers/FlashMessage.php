<?php

declare(strict_types=1);

namespace App\Helpers;

readonly class FlashMessage
{
    private string $sessionKey;

    public function __construct(string $sessionKey = 'flash')
    {
        $this->initializeSession();
        $this->initializeSessionKey($sessionKey);
    }


    protected function initializeSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function initializeSessionKey(string $sessionKey): void
    {
        $this->sessionKey = $sessionKey;
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    public function set(string $key, string $message): FlashMessage
    {
        $_SESSION[$this->sessionKey][$key] = $message;
        return $this;
    }

    public function get(string $key): null|string
    {
        if (!isset($_SESSION[$this->sessionKey][$key])) {
            return null;
        }
        $message = $_SESSION[$this->sessionKey][$key];
        unset($_SESSION[$this->sessionKey][$key]);
        return $message;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$this->sessionKey][$key]);
    }

}