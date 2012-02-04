<?php

class Config extends ActiveRecord\Model
{
    static $table_name = "config";

    public static function get($param_name = "")
    {
        $param = Config::find_by_param($param_name);
        return $param ? $param->value : '';
    }
}
