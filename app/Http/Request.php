<?php

namespace App\Http;

class Request
{

    private $router;

    private $httpMethod;

    private $uri;

    private array $queryParams = [];

    private array $postvars = [];

    private array $headers = [];

    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        $this->setPostVars();
    }

    private function setPostVars()
    {
        if($this->httpMethod == 'GET') return false;

        $this->postvars = $_POST ?? [];

        $inputRaw = file_get_contents('php://input');
        $this->postvars = (strlen($inputRaw)) && empty($_POST) ? json_decode($inputRaw, true) : $this->postvars;
    }

    private function setUri()
    {
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $exUri = explode('?', $this->uri);
        $this->uri = $exUri[0];
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getPostVars()
    {
        return $this->postvars;
    }


}