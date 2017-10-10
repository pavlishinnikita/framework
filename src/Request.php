<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/19/17
 * Time: 5:42 PM
 */

namespace Framework;

/**
 * Class Request класс для форимирования запросов
 * @package Framework
 *
 * Этот класс снабжен необходимы методами и переменными для работы с зпросами
 *
 */
class Request implements RequestInterface
{

    /**
     * Переменная хранит запросы
     *
     * @var mixed
     */
    public $data;

    /**
     * Переменная для хранения пути запроса
     *
     * @var string
     */
    public $path = null;

    private function __construct()
    {
        $this->data['get'] = $_GET;
        $this->data['post'] = $_POST;
        $this->data['server'] = $_SERVER;

        $this->path = $_SERVER['PATH_INFO'] ?? '/';
    }

    /**
     * Метод для создание запроса
     *
     * В этом методе происходит создание и инициализация экземпляра класса Request
     *
     * @return Request возвращаемый экземпляр
     */
    public static function createRequest()
    {
        return new Request();
    }

    /**
     * Метод для получения значения запроса
     * Example: $key: get.variable -> $this->data['get']['variable']
     * Example: $key: get.page.foo.second -> $this->data['get']['page']['foo']['second']
     *
     * @param string $keys ключи(переменные) запроса
     * @return string результат запроса
     */
    public function get(string $keys)
    {
        $keys = explode('.', $keys);
        $value = $this->data;
        foreach ($keys as $key) {
            $value = $value[$key];
        }

        return $value;
    }

}