<?php

class FormularHotel extends ActiveRecord\Model
{
    static $table_name = "formular_hotels";

    public function get_all_params()
    {
        $result = array(
            "room_type" => "",
            "room_capacity" => "",
            "hotel_service" => "",
        );

        $room_types = HotelOffer::find('all', array(
                'conditions' => array('hotel_id = ?', $this->hotel_id),
                'select' => 'DISTINCT roomtype_id'
            )
        );

        foreach($room_types as $type)
            $result['room_type'][] = RoomType::find_by_id($type->roomtype_id);

        $room_capacity = HotelOffer::find('all', array(
                'conditions' => array('hotel_id = ? AND roomtype_id = ?', $this->hotel_id, $this->roomtype_id),
                'select' => 'DISTINCT roomcapacity_id'
            )
        );

        foreach($room_capacity as $type)
            $result['room_capacity'][] = RoomCapacity::find_by_id($type->roomcapacity_id);


        $services = HotelOffer::find('all', array(
                'conditions' => array('hotel_id = ? AND roomtype_id = ? AND roomcapacity_id = ?',
                    $this->hotel_id, $this->roomtype_id, $this->roomcapacity_id),
                'select' => 'DISTINCT hotelservice_id'
            )
        );

        foreach($services as $type)
            $result['hotel_service'][] = HotelService::find_by_id($type->hotelservice_id);

        return $result;
    }
}
