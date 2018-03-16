<?php

namespace App\Helpers;

class AppHelper
{
    public function toSQLWithParams($toSQL)
    {
        $query = str_replace(array('?'), array('\'%s\''), $toSQL);
        $query = vsprintf($query, $toSQL->getBindings());
        return $query;
    }

    public static function instance()
    {
        return new AppHelper();
    }
}