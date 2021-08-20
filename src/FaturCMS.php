<?php

namespace Ajifatur\FaturCMS;

class FaturCMS
{
    public static function routes()
    {
        require __DIR__.'/../routes/web.php';
    }

    public static function APIroutes()
    {
        require __DIR__.'/../routes/api.php';
    }
}