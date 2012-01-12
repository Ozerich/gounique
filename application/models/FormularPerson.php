<?php

class FormularPerson extends ActiveRecord\Model
{
    static $table_name = "formular_persons";

    static $sex_map = array(
        "man" => "herr",
        "woman" => "frau",
        "child" => "kind",
        "child_less_2" => "kind < 2"
    );

    public function get_plain_text()
    {
        return $this->name . " / " . $this->surname;
    }
}
