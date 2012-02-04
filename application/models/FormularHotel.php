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

        foreach ($room_types as $type)
            $result['room_type'][] = RoomType::find_by_id($type->roomtype_id);

        $room_capacity = HotelOffer::find('all', array(
                'conditions' => array('hotel_id = ? AND roomtype_id = ?', $this->hotel_id, $this->roomtype),
                'select' => 'DISTINCT roomcapacity_id'
            )
        );

        foreach ($room_capacity as $type)
            $result['room_capacity'][] = RoomCapacity::find_by_id($type->roomcapacity_id);

        $services = HotelOffer::find('all', array(
                'conditions' => array('hotel_id = ? AND roomtype_id = ? AND roomcapacity_id = ?',
                    $this->hotel_id, $this->roomtype, $this->roomcapacity),
                'select' => 'DISTINCT hotelservice_id'
            )
        );

        foreach ($services as $type)
            $result['hotel_service'][] = HotelService::find_by_id($type->hotelservice_id);

        return $result;
    }

    public function get_is_manuel()
    {
        return $this->hotel_id == 0;
    }

    public function get_plain_text()
    {
        $text = $this->date_start->format('d.m.Y') . " - " . $this->date_end->format('d.m.Y') . " ";
        $text .= $this->days_count . "N HOTEL: " . $this->hotel_name . " / ";
        $text .= $this->roomcapacity  . " / ";
        $text .= $this->roomtype . " / ";
        $text .= HotelService::find_by_id($this->hotelservice_id)->value . " / ";
        $text .= ($this->transfer == "kein") ? '' :  " / TRANSFER " . strtoupper($this->transfer);
        $text .= ($this->remark ? ' / ' . $this->remark : '') . ($this->city_tour ? ' / ' . $this->city_tour : '');

        return $text;
    }

    public function get_nodate_text()
    {
        $text = $this->days_count . "N HOTEL: " . $this->hotel_name . " / ";
        $text .= $this->roomcapacity. " / ";
        $text .= $this->roomtype. " / ";
        $text .= HotelService::find_by_id($this->hotelservice_id)->value . " / ";
        $text .= ($this->transfer == "kein") ? '' : " / TRANSFER " . strtoupper($this->transfer);
        $text .= ($this->remark ? ' / ' . $this->remark : '') . " - &nbsp;<b>" . $this->all_price . "&euro;</b>";

        return $text;
    }

    public function get_people_count()
    {
        if($this->plain_roomcapacity == "EZ")
            return 1;
        $num = substr($this->plain_roomcapacity, -1);
        return $num == 0 ? 2 : $num;
    }

    public function get_all_price()
    {
        return ($this->price + $this->transfer_price) * $this->people_count;
    }

    public function get_status_logs()
    {
        return FormularStatusLog::find_all_by_item_id($this->id);
    }

    public function get_plain_status()
    {
        switch ($this->status)
        {
            case 'rq':
                return 'RQ';
            case 'wl':
                return 'WL';
            case 'ok':
                return 'OK';
            case 'cl':
                return 'CL';
            case 'fb':
                return 'FB';
            case 'none':
                return 'No status';
            default:
                return 'Unknown';
        }
    }

    public function get_type()
    {
        return "hotel";
    }

    public function get_hotel_code()
    {
        $hotel = Hotel::find_by_id($this->hotel_id);
        return $hotel->code;
    }

    public function get_date_str()
    {
        return ($this->date_start && $this->date_end) ? $this->date_start->format('d.m.Y') . ' - ' . $this->date_end->format('d.m.Y') : '';
    }

    public function get_voucher_name()
    {
        return "voucher_hotel_" . $this->id . ".pdf";
    }

    public function get_plain_roomtype()
    {
        return $this->roomtype;
    }

    public function get_plain_roomcapacity()
    {
        return $this->roomcapacity;
    }

    public function get_file_roomcapacity()
    {
        $formular = Formular::find_by_id($this->formular_id);
        $room_capacity = $this->roomcapacity;

        $last = substr($room_capacity, -1);
        switch ($last) {
            case "0":
                $room_capacity = "DZ";
                break;
            case "1":
                $room_capacity = "EZ";
                break;
            case "2":
                $room_capacity = "DZ";
                if ($formular->child_count)
                    $room_capacity .= " + Extra bed";
                break;
            case "3":
                $room_capacity = "DZ + Extra bed";
        }
        return $room_capacity;
    }

    public function get_plain_hotelservice()
    {
        $service = HotelService::find_by_id($this->hotelservice_id);
        return $service->value;
    }

    public function get_plain_transfer()
    {
        return strtoupper($this->transfer);
    }

    public function get_childs_count()
    {
        return FormularPerson::count(array('condition' => array('formular_id = ? AND sex = ?', $this->id, 'child')));
    }

    public function get_pdf_text()
    {
        $text = $this->date_start->format('d.m.Y') . " - " . $this->date_end->format('d.m.Y') . " ";
        $text .= $this->days_count . "N HOTEL: " . $this->hotel_name . " / ";
        $text .= $this->file_roomcapacity . " / ";
        $text .= ($this->is_manuel ? $this->roomtype : RoomType::find_by_id($this->roomtype)->value) . " / ";
        $text .= HotelService::find_by_id($this->hotelservice_id)->value;
        $text .= ($this->transfer == "kein") ? '' : " / TRANSFER " . strtoupper($this->transfer);
        $text .= ($this->remark ? ' / ' . $this->remark : '') . ($this->city_tour ? ' / ' . $this->city_tour : '');

        return $text;
    }
}
