<?php

namespace App\Database;

class DB
{
    private string $host = 'localhost';
    private string $dbname = 'mydb';
    private string $user = 'admin';
    private string $password = ' ';
    private array $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ];
    private \PDO $db;

    public function getConnection(): \PDO
    {
        $this->db = new \PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->user, $this->password, $this->options);
        return $this->db;
    }
}
