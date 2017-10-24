<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 13.10.17
 * Time: 13:53
 */

namespace Framework\Database;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Класс для работы с базой данных посредством Doctrine 2
 * Class DoctrineQuery
 * @package Framework\Database
 */
class DoctrineQuery implements QueryInterface
{

    /**
     * @var DatabaseInterface
     */
    private $database;

    /**
     * @param DatabaseInterface $database
     * @return mixed
     */
    public function setDatabase(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * Возвращает Doctrine 2 QueryBuilder, содержащий все необходимые средства работы с базой данных
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder
    {
        /** @var Connection $connection */
        $connection = $this->database->getConnection();
        return $connection->createQueryBuilder();
    }

}