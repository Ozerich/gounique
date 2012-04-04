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
            case 'uberweisung':
                return 'Uberweisung';
            case 'kreditkart':
                return 'KK über UW';
            case 'kreditkart_aer':
                return 'KK über AER';
            case 'kreditkart_dogan':
                return 'KK über AER';
            case 'lastschrift':
                return 'Lastschrift';
            case 'bar':
                return 'Bar';
            default:
                return 'Unknown';
        }
    }

}
