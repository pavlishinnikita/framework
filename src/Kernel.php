<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/19/17
 * Time: 5:41 PM
 */

namespace Framework;
use Framework\Router\Router;
require_once 'vendor/autoload.php';

class Kernel
{
    private static $instance;

    private $prefix = 'App\\Controllers\\';

    private function __construct() {}

    private function __clone() {}

    public static function getInstance()
    {
        if(Kernel::$instance == null) {
            Kernel::$instance = new Kernel();
        }
        return Kernel::$instance;
    }

    public function handle(Request $request)
    {
        $path = $request->path;
        $router = Router::getInstance();
        $matches = $router->find($path);
        $controllerAndAction = explode('@', $matches[0]);
        $controller = $controllerAndAction[0];
        $action = $controllerAndAction[1];

        $controller = $this->prefix.$controller;
        $object = new $controller();
        $arguments = array_slice($matches,1);
        call_user_func_array(array($object,$action),$arguments);

    }

}