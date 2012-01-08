<?php

class Kunde extends ActiveRecord\Model
{
    static $table_name = "kunden";

    public function get_formulars()
    {
        return Formular::find_all_by_kunde_id($this->id);
    }

    public function get_plain_type()
    {
        return $this->type;
    }

    public function get_plain_text()
    {
        $text = '';

        switch($this->type)
        {
            case 'agenturen':
                $text = $this->name . "<br />" . $this->address . "<br/>" . $this->plz .
                                " " . $this->ort;
                break;

            case 'stammkunden':
                $text = $this->name . "<br />" . $this->address . "<br/>" . $this->plz .
                                               " " . $this->ort;
                break;

            case 'incoming':
                $text = $this->name . "<br />" . $this->address . "<br/>" . $this->plz .
                                               " " . $this->ort;
                break;

            case 'mitarbeiter':
                $text = $this->name . "<br />" . $this->address . "<br/>" . $this->plz .
                                               " " . $this->ort;
                break;
        }
        
        return $text;
    }

}

?>