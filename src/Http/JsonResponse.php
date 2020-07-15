<?php


namespace App\Http;


class JsonResponse
{
    private array $body;
    private string $header;

    public function __construct(array $body, string $header)
    {
        $this->body = $body;
        $this->header = $header;
    }

    public function getBody()
    {
        return json_encode($this->body, JSON_PRETTY_PRINT);
    }

    public function getHeader()
    {
        return $this->header;
    }


}