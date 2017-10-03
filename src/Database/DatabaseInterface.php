<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/29/17
 * Time: 1:34 PM
 */

namespace Framework\Database;


interface DatabaseInterface
{

    /**
     * @param string $connectionString
     * @param string $username
     * @param string $password
     * @return DatabaseInterface
     */
    public function connect(string $connectionString, string $username, string $password): DatabaseInterface;

    /**
     * @param string $table
     * @return DatabaseInterface
     */
    public function from(string $table): DatabaseInterface;

    /**
     * @param string[] $fields
     * @return DatabaseInterface
     */
    public function get(array $fields): DatabaseInterface;

    /**
     * @param string $column
     * @param string $valueVariable
     * @param string $operator
     * @return DatabaseInterface
     */
    public function where(string $column, string $valueVariable, string $operator): DatabaseInterface;

    /**
     * @param int $take
     * @return DatabaseInterface
     */
    public function take(int $take): DatabaseInterface;

    /**
     * @param int $offset
     * @return DatabaseInterface
     */
    public function skip(int $offset): DatabaseInterface;

    /**
     * @param string $variable
     * @param $value
     * @return DatabaseInterface
     */
    public function bind(string $variable, $value): DatabaseInterface;

    /**
     * @return mixed
     */
    public function execute();

}