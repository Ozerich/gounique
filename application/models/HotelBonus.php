<?php

class HotelBonus extends ActiveRecord\Model
{
    static $table_name = "hotel_bonus";

    public function get_text()
    {
        $period = (($this->period_start) ? $this->period_start->format('d.m.Y') : 'no date').' - '.
            (($this->period_finish) ? $this->period_finish->format('d.m.Y') : 'no date').' ';

        switch($this->type)
        {
            case "night_bonus":
                return $period . $this->night_1."=".$this->night_2;
            case "long_stay":
                return $period . "Longstay for ".$this->days_count." days ".$this->discount_3."%";
            case "earlybird_date":
                return $period . "Booking till ".$this->booking_till->format('d.m.Y')." ".$this->discount_2."%";
            case "earlybird_days":
                return $period . "Booking before ".$this->days_before." days ".$this->discount_1."%";
        }

        return "Unknown bonus";
    }
}

?>