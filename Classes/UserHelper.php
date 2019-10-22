<?php

use \RedBeanPHP\R as R;

class UserHelper
{

    public function users_order_by($ord)
    {
        if (!isset($ord)) {
            $ord = 'id';
        }
        return R::getAll("select * from users order by {$ord}");
    }

    public static function generate_key()
    {
        $key = "";
        for ($i = 0; $i < 10; $i++) {
            $key .= rand(0, 9);
        }

        return $key;
    }
}