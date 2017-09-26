<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/19/17
 * Time: 5:45 PM
 */

namespace Framework;


interface RequestInterface
{

    public static function createRequest();

    /**
     * Example: $key: get.variable -> $this->data['get']['variable']
     *
     * @param string $keys
     * @return string
     */
    public function get(string $keys);

}