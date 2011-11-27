<?php

class Formular extends ActiveRecord\Model
{
    static $table_name = "formulars";

    public function get_date()
    {
        return substr($this->zahlungsdatum, 0, 2).".".substr($this->zahlungsdatum, 2, 2).".".substr($this->zahlungsdatum, 4);
    }
}

?>