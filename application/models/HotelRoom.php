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

    public function is_service_active($service_id)
    {
        return (HotelRoomService::find(array('conditions' => array('room_id = ? AND service_id = ? AND active = 1', $this->id, $service_id)))) ? true : false;
    }

    public function is_count_active($count)
    {
        return (HotelRoomType::find(array('conditions' => array('room_id = ? AND count = ? AND active = 1', $this->id, $count)))) ? true : false;
    }

}

?>