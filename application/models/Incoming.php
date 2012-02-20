<?php

class Incoming extends ActiveRecord\Model
{
    static $table_name = "incomings";

    public function get_plain_text()
    {
        return $this->name . "<br />" . $this->address . "<br/>" . $this->plz .
            " " . $this->ort . "<br/>" . $this->phone;
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