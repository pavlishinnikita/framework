<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/19/17
 * Time: 5:41 PM
 */
namespace Framework;

use App\Services\MathService;
use Framework\Router\Router;
use PHPUnit\Runner\Exception;

/**
 * Class Kernel класс для обработки запросов, ядро приложения
 * @package Framework
 */
class Kernel
{
    /**
     * Экземляр класса Kernel
     * @var Kernel
     */
    private static $instance;

    /**
     * @var \Callable[]
     */
    private $services;

    /**
     * Путь к пользовательским контроллерам
     * @var string
     */
    private $prefixControllers = 'App\\Controllers\\';

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Возвращение экземпляра класса Kernel
     *
     * Так как класс Kernel может быть единственным на все приложение используйте этот метод для получения
     * экземпляра этого класса
     *
     * @return Kernel эдинственный экземпяр класса
     */
    public static function getInstance()
    {
        if (Kernel::$instance == null) {
            Kernel::$instance = new Kernel();
        }
        return Kernel::$instance;
    }

    /**
     * Принимает запрос и обрабатывет его
     *
     * В этом методе происходит обработка запросов и на их основании создаются нужные контроллеры
     * а так же вызываются нужные действия (actions)
     *
     * @param Request $request запрос и его параметры хранятся в этой переменной
     */
    public function handle(Request $request)
    {
        $path = $request->path;
        $router = Router::getInstance();
        $matches = $router->find($path);
        $controllerAndAction = explode('@', $matches[0]);
        $controller = $controllerAndAction[0];
        $action = $controllerAndAction[1];
        $controller = $this->prefixControllers . $controller;
        $objectController = new $controller();
        $simpleArgs = array_reverse(array_slice($matches, 1));
        $arguments = [];
        $reflectionClass = new \ReflectionClass($objectController);

        if($reflectionClass->hasMethod($action)) {
            $reflectionMethod = $reflectionClass->getMethod($action);
            $params = $reflectionMethod->getParameters();
            foreach ($params as $param) {
                /** ReflectionParameter $param */
                $paramClass = $param->getClass();
                if(!is_null($paramClass)) {
                    $objectParam = $this->make($paramClass->getName());
                    array_push($arguments, $objectParam);
                } else {
                    array_push($arguments, array_pop($simpleArgs));
                }
            }
        }
        else {
            throw new Exception("Not member this method");
        }

        call_user_func_array([ $objectController, $action ], $arguments);
    }

    /**
     * @param string $target
     * @param \Closure|mixed $realization
     * @return Kernel
     */
    public function register(string $target, $realization) {
        $this->services[$target] = $realization;
        return $this;
    }

    /**
     * @param string $service
     * @return mixed
     */
    public function make(string $service) {

        if (!array_key_exists($service, $this->services)) {
            return new $service;
        }

        if (is_callable($this->services[$service])) {
            $callable = $this->services[$service];
            $createdService = call_user_func($callable);
            return $createdService;
        }
        return new $this->services[$service];
    }
}
