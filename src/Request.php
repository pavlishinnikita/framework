<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/19/17
 * Time: 5:42 PM
 */

namespace Framework;


class Request implements RequestInterface
{

    /**
     * @var mixed
     */
    public $data;

    /**
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

    public static function createRequest()
    {
        return new Request();
    }

    /**
     * Example: $key: get.variable -> $this->data['get']['variable']
     * Example: $key: get.page.foo.second -> $this->data['get']['page']['foo']['second']
     *
     * @param string $keys
     * @return string
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