<?php


namespace App\Repositories;


use App\Models\Author;

interface AuthorRepository
{
    public function create(Author $author);
    public function update(int $phone);
    public function getId(int $phone);
    public function getLastMessageTime(int $phone);
}