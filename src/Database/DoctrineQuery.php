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
     * @return \Doctrine\DBAL\Query\QueryBuilder
     */
    public function createQueryBuilder(): QueryBuilder
    {
        /** @var Connection $connection */
        $connection = $this->database->getConnection();
        return $connection->createQueryBuilder();
    }

}