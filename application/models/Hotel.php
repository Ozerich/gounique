<?php

class Hotel extends ActiveRecord\Model
{
    static $table_name = "hotels";

    public function get_minimums()
    {
        $data = HotelMinimum::find_all_by_hotel_id($this->id);
        return $data ? $data : array();
    }

    public function get_childs()
    {
        $data = HotelChildAge::all(array('conditions' => array('hotel_id = ? and type = ?', $this->id, 'child')));
        return $data ? $data : array();
    }

    public function get_teens()
    {
        $data = HotelChildAge::all(array('conditions' => array('hotel_id = ? and type = ?', $this->id, 'teen')));
        return $data ? $data : array();
    }

    public function get_infants()
    {
        $data = HotelChildAge::all(array('conditions' => array('hotel_id = ? and type = ?', $this->id, 'infant')));
        return $data ? $data : array();
    }

    public function get_rooms()
    {
        $rooms = HotelRoom::find_all_by_hotel_id($this->id);
        return $rooms ? $rooms : array();
    }

    public function get_room_types()
    {
        $result = array();

        foreach ($this->rooms as $room)
            foreach (HotelRoomType::find_all_by_room_id($room->id) as $room_type)
                if($room_type->active)
                    $result[] = $room_type;

        return $result;
    }

    public function get_child_types()
    {
        $result = array();

        if ($this->teenblock_active)
            foreach ($this->teens as $teen)
                if ($teen->active)
                    $result[] = $teen;

        if ($this->childblock_active)
            foreach ($this->childs as $child)
                if ($child->active)
                    $result[] = $child;

        if ($this->infantblock_active)
            foreach ($this->infants as $infant)
                if ($infant->active)
                    $result[] = $infant;

        return $result;
    }

    public function get_bonuses()
    {
        $data = HotelBonus::find_all_by_hotel_id($this->id);
        return $data ? $data : array();
    }

    public function get_changed_by_user()
    {
        $data = User::find_by_id($this->changed_by);
        return $data ? $data : null;
    }
}

?>