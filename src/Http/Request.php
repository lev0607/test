<?php


namespace App\Http;


class Request
{
    private $method;
    private $type;
    private $uri;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->type = $_SERVER['CONTENT_TYPE'] ?? '';
        $this->uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getUri()
    {
        return $this->uri;
    }

    function getJsonData()
    {
        $jsonStr = file_get_contents('php://input');
        return json_decode($jsonStr, true);
    }
}