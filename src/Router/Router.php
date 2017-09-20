<?php

namespace Framework\Router;

use Cake\Collection\Collection;

class Router
{
    private static $instance;
    private $rules = [];

    public static function getInstance()
    {
        if (self::$instance==null) {
            self::$instance = new Router();
        }
        return self::$instance;
    }

    private function __construct() { }

    private function __clone() { }

    public function get(string $query, string $action): bool
    {
        return $this->addRule($query, $action, 'get');
    }

    public function post(string $query, string $action): bool
    {
        return $this->addRule($query, $action, 'post');
    }

    public function put(string $query, string $action): bool
    {
        return $this->addRule($query, $action,'put');
    }

    public function delete(string $query, string $action)
    {
        return $this->addRule($query,$action,'delete');
    }

    public function find(string $query, string $method = 'get')
    {
        if(strlen($query)!=1) {
            $query = rtrim($query,'/');
        }

        $rules = new Collection($this->rules);
        $rule = $rules->filter(function ($rule) use ($query, $method) {
            return $rule['method'] === $method && preg_match("#{$rule['query']}#", $query);
        })->first();

        if ($rule === null) {
            return ["ErrorController@routeError"];
        }

        preg_match_all("/{$rule['query']}/", $query, $matches);
        array_shift($matches);
        $matches = new Collection($matches);
        $matches = $matches->map(function ($item, $key) {
            return array_values($item)[0] ?? null;
        })->toArray();

        array_unshift($matches, implode('@', [ $rule['controller'], $rule['action'] ]));

        return $matches;
    }

    protected function addRule(string $query, string $action, string $method): bool
    {
        list($controller, $action) = explode('@', $action);
        preg_match_all('#\{([0-9A-z]+)\}#', $query, $matches);
        list($patterns, $variables) = $matches;

        $query = preg_replace('#\{([0-9A-z]+)\}#', '([0-9A-z]+)', $query);

        $query = str_replace('/', '\/', $query);
        $query = "^{$query}$";

        array_push($this->rules, [
            'query' => $query,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ]);

        return true;
    }

}