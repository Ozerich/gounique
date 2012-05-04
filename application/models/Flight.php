<?php

class Flight extends ActiveRecord\Model
{
    static $table_name = "flights";


    public function get_classes()
    {
        $data = FlightAge::all(array('conditions' => array('flight_id = ?', $this->id), 'order' => 'pos ASC'));
        return $data ? $data : array();
    }

    public function get_days()
    {
        $data = FlightDay::all(array('conditions' => array('flight_id = ?', $this->id), 'order' => 'date ASC'));
        return $data ? $data : array();
    }
}
