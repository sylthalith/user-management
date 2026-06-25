<?php

namespace App;

class Request
{
    public function isAjax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    }
}