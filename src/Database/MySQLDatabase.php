<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/29/17
 * Time: 1:37 PM
 */

namespace Framework\Database;


use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;

/**
 * Class MySQLDatabase
 * @package Framework\Database
 *
 * Класс для работы с MySQL базой данных
 */
class MySQLDatabase implements DatabaseInterface
{

    /**
     * @var DriverManager
     */
    private $connection;

    /**
     * Метод для соединения с базой данных
     *
     * @param string $connectionString - строка соединения в формате JDBC Example: "mysql://host:port/db_name
     * @param string $username - имя пользователя
     * @param string $password - пароль
     * @return DatabaseInterface
     *
     */
    public function connect(string $connectionString, string $username, string $password): DatabaseInterface
    {
        $regex = "#([A-z]+:\/\/)([A-z0-9\.]+):([0-9]+)\/([A-z0-9]+)#";
        preg_match_all($regex, $connectionString, $matches);
        array_shift($matches);
        $config = new Configuration();
        $connectionParams = array(
            'dbname' => $matches[3][0],
            'user' => $username,
            'password' => $password,
            'host' => $matches[1][0],
            'driver' => 'pdo_mysql',
        );
        $this->connection = DriverManager::getConnection($connectionParams, $config);
        return $this;
    }

    /**
     * Позволяет получить экземляр соединения с базой данных
     *
     * @return DriverManager
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Создает построитель запросов
     *
     * @return QueryInterface
     */
    public function createQuery(): QueryInterface
    {
        $doctrineQuery = new DoctrineQuery();
        $doctrineQuery->setDatabase($this);
        return $doctrineQuery;
    }
}