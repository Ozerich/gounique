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

    public function get_plain_text()
    {
        $text = $this->date_start->format('d.m.Y') . " - ".$this->date_end->format('d.m.Y') . " ";
        $text .= $this->days_count . "N HOTEL: " . $this->hotel_name . " / ";
        $text .= RoomCapacity::find_by_id($this->roomcapacity_id)->value . " / ";
        $text .= RoomType::find_by_id($this->roomtype_id)->value . " / ";
        $text .= HotelService::find_by_id($this->hotelservice_id)->value . " / ";
        $text .= "TRANSFER " . strtoupper($this->transfer) . " / ";
        $text .= $this->remark . " - &nbsp;<b>" . $this->price . "&euro;</b>";

        return $text;
    }

    public function get_nodate_text()
    {
        $text = $this->days_count . "N HOTEL: " . $this->hotel_name . " / ";
        $text .= RoomCapacity::find_by_id($this->roomcapacity_id)->value . " / ";
        $text .= RoomType::find_by_id($this->roomtype_id)->value . " / ";
        $text .= HotelService::find_by_id($this->hotelservice_id)->value . " / ";
        $text .= "TRANSFER " . strtoupper($this->transfer) . " / ";
        $text .= $this->remark . " - &nbsp;<b>" . $this->price . "&euro;</b>";

        return $text;
    }

    public function get_status_logs()
    {
        return FormularStatusLog::find_all_by_item_id($this->id);
    }

    public function get_plain_status()
    {
        switch($this->status)
        {
            case 'rq':
                return 'RQ';
            case 'wl':
                return 'WL';
            case 'ok':
                return 'OK';
            default:
                return 'No status';
        }
    }

    public function get_type()
    {
        return "hotel";
    }
}
