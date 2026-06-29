<?php

namespace App;

class Request
{
    public function isAjax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }

    public function getUri(array $params = []): string
    {
        $get = array_replace($_GET, $params);

        return parse_url($_SERVER['REQUEST_URI'])['path'] . '?' . http_build_query($get);
    }

    public function getQueryInt(string $key, int $default): int
    {
        return isset($_GET[$key]) ? (int) $_GET[$key] : $default;
    }
}