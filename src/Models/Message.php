<?php

namespace App\Models;

class Message
{
    private int $authorId;
    private string $content;

    public function __construct(int $authorId, string $content)
    {
        $this->authorId = $authorId;
        $this->content = $content;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }
    public function getContent()
    {
        return $this->content;
    }
}