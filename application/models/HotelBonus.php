<?php

class HotelBonus extends ActiveRecord\Model
{
    static $table_name = "hotel_bonus";

    public function get_text()
    {
        return "BONUS";
    }
}

?>