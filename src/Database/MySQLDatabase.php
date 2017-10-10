<?php
/**
 * Created by PhpStorm.
 * User: nikita
 * Date: 9/29/17
 * Time: 1:37 PM
 */

namespace Framework\Database;


class MySQLDatabase implements DatabaseInterface
{

    /**
     * @var \mysqli
     */
    private $connection;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $query;

    /**
     *
     *
     * @var mixed[]
     */
    private $whereRules = [];

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
        list($connectionType, $host, $port, $db) = $matches;
        $this->connection = mysqli_connect($host[0], $username, $password, $db[0], (int)$port[0]);
        return $this;
    }

    /**
     * @param string $table
     * @return DatabaseInterface
     */
    public function from(string $table): DatabaseInterface
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @param string[] $fields
     * @return DatabaseInterface
     */
    public function get(array $fields): DatabaseInterface
    {
        $str_field = implode(',', $fields);
        $this->query = "SELECT $str_field ";
        return $this;
    }

    /**
     * @param string $column
     * @param string $valueVariable
     * @param string $operator
     * @return DatabaseInterface
     */
    public function where(string $column, string $valueVariable, string $operator): DatabaseInterface
    {
        array_push($this->whereRules, [$column, ':' . $valueVariable, $operator]);
        return $this;
    }

    /**
     * @param int $take
     * @return DatabaseInterface
     */
    public function take(int $take): DatabaseInterface
    {
        // TODO: Implement take() method.
    }

    /**
     * @param int $offset
     * @return DatabaseInterface
     */
    public function skip(int $offset): DatabaseInterface
    {
        // TODO: Implement skip() method.
    }

    /**
     * @param string $variable
     * @param $value
     * @return DatabaseInterface
     */
    public function bind(string $variable, $value): DatabaseInterface
    {
        return $this;
    }

    public function execute()
    {
        $results = [];
        $rules = \collection($this->whereRules)
            ->map(function ($rule) {
                return "{$rule[0]} = {$rule[1]}";
            })
            ->toArray();
        $rules = implode(' AND ', $rules);
        $this->query .= "FROM " . $this->table;
        if (strlen($rules) > 0) {
            $this->query .= ' WHERE ' . $rules;
        }
        $stmt = $this->connection->prepare($this->query);

        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            while ($data = $result->fetch_assoc()) {
                $results[] = $data;
            }
            $stmt->close();
        }

        return $results;
    }
    public function preExecute()
    {
        $rules = \collection($this->whereRules)
            ->map(function ($rule) {
                return "{$rule[0]} {$rule[2]} {$rule[1]}";
            })
            ->toArray();
        $rules = implode(' AND ', $rules);
        $this->query .= "FROM " . $this->table;
        if (strlen($rules) > 0) {
            $this->query .= ' WHERE ' . $rules;
        }
        return $this->query;
    }

}