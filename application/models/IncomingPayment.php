<?php

class IncomingPayment extends ActiveRecord\Model
{
    static $table_name = "incoming_payments";

    public function get_user()
    {
        return User::find_by_id($this->user_id);
    }

    public function get_plain_type()
    {
        switch($this->type){
            case 'card':
                return 'Credit Card';
            case 'bank':
                return 'Bank Transfer';
            case 'cash':
                return 'Cash Money';
            default:
                return 'Unknown';
        }
    }

}
