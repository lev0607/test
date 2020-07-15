<?php


namespace App\Repositories;

use App\Models\Author;

class DbAuthorRepository implements AuthorRepository
{
    private \PDO $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }
    public function create(Author $author)
    {
        $stmt = $this->conn->prepare('INSERT INTO authors (phone) VALUES (:phone)');
        $stmt->execute(['phone' => $author->getPhone()]);
    }

    public function update(int $phone)
    {
        $stmt = $this->conn->prepare('UPDATE authors
                                SET datetime_last_message = now(), messages_count = messages_count + 1
                                WHERE phone = :phone');
        $stmt->execute(['phone' => $phone]);
    }

    public function getId(int $phone)
    {
        $stmt = $this->conn->prepare('select id from authors where phone = :phone');
        $stmt->execute(['phone' => $phone]);

        return $stmt->fetchColumn();
    }

    public function getLastMessageTime(int $phone)
    {
        $stmt = $this->conn->prepare('select datetime_last_message from authors where phone = :phone');
        $stmt->execute(['phone' => $phone]);

        return $stmt->fetchColumn();
    }
}