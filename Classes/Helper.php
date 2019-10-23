<?php

use \RedBeanPHP\R as R;

class Helper
{

    public function users_order_by($ord)
    {
        if (!isset($ord)) {
            $ord = 'id';
        }
        return R::getAll("select * from users order by {$ord}");
    }

}