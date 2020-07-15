<?php


namespace App\Repositories;


use App\Models\Message;

class DbMessageRepository implements MessageRepository
{
    private \PDO $conn;

    public function __construct(\PDO $conn)
    {
        $this->conn = $conn;
    }

    public function create(Message $message)
    {
        $stmt = $this->conn->prepare('INSERT INTO messages (authors_id, content)
            VALUES (:authors_id, :content)');
        $stmt->execute(['authors_id' => $message->getAuthorId(), 'content' => $message->getContent()]);
    }

    public function find(int $authorId)
    {
        $stmt = $this->conn->prepare('SELECT content FROM messages WHERE authors_id = :authorId');
        $stmt->execute(['authorId' => $authorId]);

        return $stmt->fetchColumn();
    }
    public function findAll()
    {
        $stmt = $this->conn->query(
            'SELECT messages.id AS message_id,
                authors_id,
                datetime,
                content,
                datetime_first_message,
                datetime_last_message,
                messages_count
                FROM messages, authors
                WHERE is_deleted = 0 AND is_banned = 0'
        );

        return $stmt->fetchAll();
    }
}