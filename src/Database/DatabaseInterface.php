<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/29/17
 * Time: 1:34 PM
 */

namespace Framework\Database;

/**
 * Общий интерфейс для баз данных
 * Interface DatabaseInterface
 * @package Framework\Database
 */
interface DatabaseInterface
{

    /**
     * Метод соединения с базой данных
     *
     * @param string $connectionString строка ведущая к базе данных Example: "mysql://host:port/db_name"
     * @param string $username имя пользователя базы данных
     * @param string $password пароль пользователя базы данных
     * @return DatabaseInterface
     */
    public function connect(string $connectionString, string $username, string $password): DatabaseInterface;

    /**
     * Возвращает соединение с базой данных
     *
     * @return mixed
     */
    public function getConnection();

    /**
     * Создает объект для работы с базой данных, для работы с запросами
     *
     * @return QueryInterface
     */
    public function createQuery(): QueryInterface;

}