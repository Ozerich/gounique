<?php

class FlightPayment extends ActiveRecord\Model
{
    static $table_name = "flight_payments";

    static $TYPES = array(
        '1' => 'Uberweisung',
        '2' => 'KK über UW',
        '3' => 'KK über AER',
        '4' => 'Lastschrift',
        '5' => 'Bar',
    );

    public function get_plain_type()
    {
        return isset(FlightPayment::$TYPES[$this->type]) ? FlightPayment::$TYPES[$this->type] : 'Unknown';
    }

}
