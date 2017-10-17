<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 13.10.17
 * Time: 13:53
 */

namespace Framework\Database;


use Doctrine\DBAL\Query\QueryBuilder;

interface QueryInterface
{

    /**
     * @param DatabaseInterface $database
     * @return mixed
     */
    public function setDatabase(DatabaseInterface $database);

    public function createQueryBuilder() : QueryBuilder;

}