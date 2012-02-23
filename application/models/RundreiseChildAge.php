<?php

class RundreiseChildAge extends ActiveRecord\Model
{
    static $table_name = "rundreise_child_ages";

    public function get_name()
    {
        $result = "";

        if($this->type == "teen")
            $result = "Jung ";
        elseif($this->type == "child")
            $result = "Kind ";
        elseif($this->type == "infant")
            $result = "Baby ";

        $result .= $this->von."-".$this->bis;

        return $result;
    }

}

?>