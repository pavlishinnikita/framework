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
     * Экземпляр интерфейса базы данных для работы с базой данных
     *
     * @var DatabaseInterface
     */
    private $database;

    /**
     * Устанавливает базу данных для дальнейшей работы с ней
     *
     * @param DatabaseInterface $database
     */
    public function setDatabase(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * Возвращает Doctrine 2 QueryBuilder, содержащий все необходимые средства работы с базой данных
     *
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder
    {
        /** @var Connection $connection */
        $connection = $this->database->getConnection();
        return $connection->createQueryBuilder();
    }

}