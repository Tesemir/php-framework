<?php

namespace Somecode\Framework\Http;

class Request
{
    private readonly array $getParams;
    private readonly array $postData;
    private readonly array $cookies;
    private readonly array $files;
    private readonly array $server;
    public function __construct($getParams, $postData, $cookies, $files, $server)
    {
        $this->getParams = $getParams;
        $this->postData = $postData;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
    }
    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPath(): string
    {
        return strtok($this->server['REQUEST_URI'], '?');
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }
}