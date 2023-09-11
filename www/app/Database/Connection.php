<?php

namespace App\Database;

use PDO;

class Connection
{
    /**
     * @var PDO
     */
    protected PDO $connection;

    /**
     *
     */
    public function __construct()
    {
        $host = '192.168.1.11';
        $database = 'okr';
        $user = 'root';
        $password = 'root';

        $dsn = "mysql:host=$host;port=9901;dbname=$database";

        $pdoConnection = new PDO($dsn, $user, $password);
        $pdoConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdoConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $this->connection = $pdoConnection;
    }

    /**
     * @return PDO
     */
    public function connection(): PDO
    {
        return $this->connection;
    }
}