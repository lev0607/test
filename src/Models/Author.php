<?php

namespace App\Models;

class Author
{
    private int $phone;

    public function __construct(int $phone)
    {
        $this->phone = $phone;
    }

    public function getPhone()
    {
        return $this->phone;
    }

}