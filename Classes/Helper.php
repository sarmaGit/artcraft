<?php

use \RedBeanPHP\R as R;

class Helper
{

    public static function order_by($table = 'users', $ord = 'id')
    {

        if (!isset($ord)) {
            $ord = 'id';
        }

        return R::getAll("select * from {$table} order by {$ord}");
    }

}