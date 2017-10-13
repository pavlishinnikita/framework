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

class MySQLDatabase implements DatabaseInterface
{

    /**
     * @var DriverManager
     */
    private $connection;


    /**
     * @param string $connectionString
     * @param string $username
     * @param string $password
     * @return DatabaseInterface
     */
    public function connect(string $connectionString, string $username, string $password): DatabaseInterface
    {
        $regex = "@([A-z]+:\/\/)([A-z0-9\.]+):([0-9]+)\/([A-z0-9]+)@";
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

    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return QueryInterface
     */
    public function createQuery(): QueryInterface
    {
        $doctrineQuery = new DoctrineQuery();
        $doctrineQuery->setDatabase($this);
        return $doctrineQuery;
    }
}