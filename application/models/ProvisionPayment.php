<?php

class ProvisionPayment extends ActiveRecord\Model
{
    static $table_name = "provision_payments";

    public function get_user()
    {
        return User::find_by_id($this->user_id);
    }

}
