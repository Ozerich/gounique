<?php

class Agency extends ActiveRecord\Model
{
    static $table_name = "agencies";

    public function get_formulars()
    {
        return Formular::find_all_by_agency_id($this->id);
    }

    public function get_plain_text()
    {
        $text = "";
        if ($this->type == 'agency')
            $text = $this->name . "<br />" . $this->address . "<br/>" . $this->plz .
                " " . $this->ort;
        else
            $text = $this->address . "<br/>" . $this->plz . " " . $this->ort;

        return $text;
    }

}
