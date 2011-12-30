<?php

class FormularStatusLog extends ActiveRecord\Model
{
    static $table_name = "formular_status_log";

    public function get_user()
    {
        return User::find_by_id($this->user_id);
    }
}
