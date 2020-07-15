<?php


namespace App\Repositories;


use App\Models\Message;

interface MessageRepository
{
    public function create(Message $message);
    public function find(int $autorId);
    public function findAll();
}