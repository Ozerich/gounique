<?php

class Formular_model extends ActiveRecord\Model
{
    static $table_name = "formulars";

    public function get_date()
    {
        return substr($this->zahlungsdatum, 0, 2) . "." . substr($this->zahlungsdatum, 2, 2) . "." . substr($this->zahlungsdatum, 4);
    }

    public function get_hotel_list()
    {
        $hotels = unserialize($this->hotels);
        if ($hotels)
            foreach ($hotels as &$hotel)
            {
                $hotel['all_params'] = array('room_type' => array(), 'room_capacity' => array(), 'room_service' => array());

                $params = Hotel::all(array('conditions' => array('code = ?', @$hotel['code']),
                                     'select' => 'DISTINCT room_type'));
                foreach ($params as $param)
                    $hotel['all_params']['room_type'][] = $param->room_type;

                $params = Hotel::all(array("select" => "DISTINCT room_capacity", "conditions" => array("code = ? AND room_type = ?", @$hotel['code'], $hotel['room_type'])));
                foreach ($params as $param)
                    $hotel['all_params']['room_capacity'][] = $param->room_capacity;

                $params = Hotel::all(array("select" => "DISTINCT room_service", "conditions" => array("code = ? AND room_type = ? AND room_capacity = ?", @$hotel['code'], $hotel['room_type'], $hotel['room_capacity'])));
                foreach ($params as $param)
                    $hotel['all_params']['room_service'][] = $param->room_service;

            }
        return $hotels;
    }

    public function get_manuel_list()
    {
        return unserialize($this->manuels);
    }

    public function get_person_list()
    {
        return unserialize($this->persons);
    }

    public function get_agency()
    {
        return Agency_model::find_by_id($this->k_num);
    }
}

?>