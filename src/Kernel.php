<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/19/17
 * Time: 5:41 PM
 */
namespace Framework;

use Framework\Router\Router;
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
     * и вызыванются нужные действия (actions)
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
        $object = new $controller();
        $arguments = array_slice($matches, 1);
        call_user_func_array([$object, $action], $arguments);
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
        if (is_callable($this->services[$service])) {
            $callable = $this->services[$service];
            $createdService = call_user_func($callable);

            return $createdService;
        }

        return $this->services[$service];
    }

}
