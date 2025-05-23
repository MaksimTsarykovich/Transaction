<?php

declare(strict_types=1);

namespace Core;

use src\Exceptions\ViewNotFoundException;

class View
{
    protected string $view;
    protected array $params = [];

    public function __construct(string $view, array $params = [])
    {
        $this->view = $view;
        $this->params = $params;
    }

    public static function make(string $view, array $params = []): static
    {
        return new static($view, $params);
    }

    public function render(): string
    {
        $viewPath = $this->getViewPath();

        $this->checkViewExists($viewPath);

        $this->convertParamsToVariables();
        
        return $this->renderView($viewPath);
    }

    protected function getViewPath(): string
    {
        return VIEW_PATH . '/' . $this->view . '.php';
    }

    protected function checkViewExists(string $viewPath): void
    {
        if (!file_exists($viewPath)) {
            throw new ViewNotFoundException();
        }
    }

    protected function convertParamsToVariables(): void
    {
        foreach ($this->params as $key => $value) {
            $$key = $value;
        }
    }

    protected function renderView($viewPath): string
    {
        ob_start();
        include $viewPath;
        return (string) ob_get_clean();
    }


    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $key)
    {
        return $this->params[$key] ?? null;
    }
}