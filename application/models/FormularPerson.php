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

    public function get_plain_sex()
    {
        return strtoupper($this->sex);
    }

    public function get_english_sex()
    {
        if($this->sex == "herr")
            return "MR";
        else if($this->sex == "frau")
            return "MRS";
        else if($this->sex == "child")
            return "CHD";
        else if($this->sex == "infant")
            return "INF";
        return '';
    }
}
