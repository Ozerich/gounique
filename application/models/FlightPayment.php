<?php

class FlightPayment extends ActiveRecord\Model
{
    static $table_name = "flight_payments";

    static $TYPES = array(
        '1' => 'Uberweisung',
        '2' => 'Kreditkart',
        '3' => 'Lastschrift',
        '4' => 'Bar');

    public function get_plain_type()
    {
        return isset(FlightPayment::$TYPES[$this->type]) ? FlightPayment::$TYPES[$this->type] : 'Unknown';
    }

}
