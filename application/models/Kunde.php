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
                $text = $this->name . "<br />" . $this->strasse . "<br/>" . $this->plz .
                                " " . $this->ort . "<br/>" . $this->phone;
                break;

            case 'stammkunden':
                $text = $this->name . "<br />" . $this->strasse . "<br/>" . $this->plz .
                                               " " . $this->ort . "<br/>" . $this->phone;
                break;

            default:
                $text = "Unknown type";
        }
        
        return $text;
    }

    public function get_changed_user(){
        return User::find_by_id($this->changed_by);
    }

    public function get_provision(){
        $level = ProvisionLevel::find_by_id($this->provision_level);
        return $level ? $level->percent : 0;
    }
}

?>