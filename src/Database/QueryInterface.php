<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 13.10.17
 * Time: 13:53
 */

namespace Framework\Database;


use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Интерфейс для всех запросов
 * Interface QueryInterface
 * @package Framework\Database
 */
interface QueryInterface
{

    /**
     * Устанавливает базу данных для дальнейшей работы с ней
     *
     * @param DatabaseInterface $database
     * @return mixed
     */
    public function setDatabase(DatabaseInterface $database);

    /**
     * Создает построитель запросов
     * @return QueryBuilder
     */
    public function createQueryBuilder() : QueryBuilder;

}