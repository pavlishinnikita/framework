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

    private $prefix = 'App\\Controllers\\';
    public function handle(Request $request)
    {
        $path = $request->path;
        $router = Router::getInstance();
        $matches = $router->find($path);
        $controller = explode('@',$matches[0])[0];
        $action = explode('@',$matches[0])[1];
        $params = $matches[1];
        // call controller and action
        $controller = $this->prefix.$controller;
        $object = new $controller();

        if($params==null)
            $object->$action();
        else
            $object->$action($params);

    }

}