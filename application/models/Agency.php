<?php

class Agency extends ActiveRecord\Model
{
    static $table_name = "agencies";

    public function get_formulars()
    {
        return Formular::find_all_by_agency_id($this->id);
    }
    
}
