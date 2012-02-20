<?php

class Kette extends ActiveRecord\Model
{
    static $table_name = "ketten";

    public function get_changed_user(){
        return User::find_by_id($this->changed_by);
    }

}

?>