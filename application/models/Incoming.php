<?php

class Incoming extends ActiveRecord\Model
{
    static $table_name = "incomings";

    public function get_plain_text()
    {
        return $this->name . "<br />" . $this->kontakt_strasse . "<br/>" . $this->kontakt_plz .
            " " . $this->kontakt_ort . "<br/>" . $this->kontakt_phone;
    }

    public function get_invoices()
    {
        $data = Invoice::find_all_by_incoming_id($this->id);
        return $data ? $data : array();
    }

    public function get_changed_user(){
        return User::find_by_id($this->changed_by);
    }

}

?>