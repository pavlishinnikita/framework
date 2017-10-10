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
     * Метод для указания таблицы для выборки
     *
     * При составлении запроса этот метод используется для указания сущности из которой проводится выборка
     *
     * @param string $table имя таблицы
     * @return DatabaseInterface
     */
    public function from(string $table): DatabaseInterface;

    /**
     * Метод для указания полей выборки
     *
     * @param string[] $fields поля выборки
     * @return DatabaseInterface
     */
    public function get(array $fields): DatabaseInterface;

    /**
     * Задает условия запроса
     *
     * В этот метод передаются названия полей, их значения и операции, которые выполнятся на ними
     * Это есть часть запроса
     *
     * @param string $column поля базы данных
     * @param string $valueVariable значения полей переменной $column
     * @param string $operator операция
     * @return DatabaseInterface
     */
    public function where(string $column, string $valueVariable, string $operator): DatabaseInterface;

    /**
     * Указание колличества выбираемых елементов
     *
     * Метод позволяет указать какое колличество записей нужно выбрать
     *
     * @param int $take колличество элементов
     * @return DatabaseInterface
     */
    public function take(int $take): DatabaseInterface;

    /**
     * Указание колличества пропускаемых элементов
     *
     * Этот метод позвояет указать сколько нужно пропустить строк в выборке
     *
     *
     * @param int $offset колличество элементов
     * @return DatabaseInterface
     */
    public function skip(int $offset): DatabaseInterface;

    /**
     * Метод для подстановки значений переменным в запросе
     *
     * Заменяет заданные переменные в методе where() значениями из переменной $value
     *
     * @param string $variable переменная
     * @param $value значение
     * @return DatabaseInterface
     */
    public function bind(string $variable, $value): DatabaseInterface;

    /**
     * Выполнение запроса
     * Составляет запрос выборки, а потом выполняет его в случае неудачи выбрасывает исключение @throws \Exception
     * @return mixed данные выборки
     */
    public function execute();


}