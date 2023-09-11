<?php

namespace App\Repository;

use App\Database\Connection;
use PDO;
use PDOStatement;

abstract class AbstractRepository
{
    /**
     * @var Connection
     */
    protected Connection $connection;

    /**
     *
     */
    public function __construct()
    {
        $this->connection = new Connection();
    }

    /**
     * @return string
     */
    abstract public function getEntity(): string;

    /**
     * @return PDO
     */
    protected function connection(): PDO
    {
        return $this->connection->connection();
    }

    /**
     * @param $query
     * @return false|PDOStatement
     */
    private function prepareQuery($query): false|PDOStatement
    {
        return $this->connection()->prepare($query);
    }

    /**
     * @param $query
     * @param array $parameters
     * @return array
     */
    protected function select($query, array $parameters): array
    {
        $statment = $this->prepareQuery($query);

        if (!$statment->execute($parameters)) {
            return [];
        }

        $entityList = [];

        while ($entity = $statment->fetchObject($this->getEntity())) {
            $entityList[] = $entity;
        }

        return $entityList;
    }

    /**
     * @param $query
     * @param array $parameters
     * @return bool
     */
    protected function insert($query, array $parameters): bool
    {
        $statment = $this->prepareQuery($query);

        return $statment->execute($parameters);
    }

    /**
     * @param $query
     * @param array $parameters
     * @return bool
     */
    protected function update($query, array $parameters): bool
    {
        $statment = $this->prepareQuery($query);

        return $statment->execute($parameters);
    }

    /**
     * @param $query
     * @param array $parameters
     * @return bool
     */
    protected function delete($query, array $parameters): bool
    {
        $statment = $this->prepareQuery($query);

        return $statment->execute($parameters);
    }
}