<?php

class HotelRoomType extends ActiveRecord\Model
{
    static $table_name = "hotel_room_type";

    public function get_cat_name()
    {
        $cat = HotelRoom::find_by_id($this->room_id);
        return $cat ? $cat->name : '';
    }

    public function get_differencies()
    {
        $data = HotelRoomDifference::find_all_by_room_id($this->id);

        if (!$data)
            return array();

        $result = array();

        foreach ($data as $ind=>$item)
        {
            $types = HotelRoomDifferenceItem::find_all_by_room_difference_id($item->id);

            foreach ($types as $type)
                $result[$ind][$type->childage_id] = $type->value;
        }

        return $result;
    }

    public function get_services()
    {
        return $this->roomcat->services;
    }

    public function get_roomcat()
    {
        return HotelRoom::find_by_id($this->room_id);
    }
}

?>