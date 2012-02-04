<?php

class HotelRoom extends ActiveRecord\Model
{
    static $table_name = "hotel_room";

    public function get_code()
    {
        $words = explode(' ',$this->name);
        $result = '';

        foreach($words as $word)
            $result .= $word[0];

        return $result;
    }

    public function get_services()
    {
        $items = HotelRoomService::all(array('conditions' => array('room_id = ? AND active = 1', $this->id)));
        $result = array();

        foreach($items as $item)
            $result[] = Service::find_by_id($item->service_id);

        return $result;
    }

}

?>