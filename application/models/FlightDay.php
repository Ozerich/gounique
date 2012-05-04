<?php

class FlightDay extends ActiveRecord\Model
{
    static $table_name = "flight_days";

    public function get_plain_departure()
    {
        return $this->date->format('d.m.Y') . ' ' . substr($this->time_departure,0,5);
    }

    public function get_plain_arrival()
    {
        if ($this->time_departure > $this->time_arrive)
            return $this->date->add(new DateInterval('P2D'))->format('d.m.Y') . ' ' . substr($this->time_arrive,0,5);
        return $this->date->format('d.m.Y') . ' ' . substr($this->time_arrive,0,5);
    }

    public function get_flight()
    {
        return Flight::find_by_id($this->flight_id);
    }

}
