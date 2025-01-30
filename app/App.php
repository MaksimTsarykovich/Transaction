<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\RouterNotFoundException;

class App
{
    private static DB $db;
    protected Router $router;
    protected array $request;
    protected Config $config;

    public function __construct()
    {
        static::$db = new DB($config->db ?? []);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run(): void
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouterNotFoundException) {
            http_response_code(404);
            echo View::make('error/404');
        }
    }
}
