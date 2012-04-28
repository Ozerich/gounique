<?php

class RoomPeriod extends ActiveRecord\Model
{
    static $table_name = "room_periods";

    public function get_text_period()
    {
        return $this->start->format('d.m.y')." - ".$this->finish->format('d.m.y');
    }

    public function get_child_prices()
    {
        $data = PeriodChildPrice::find_all_by_period_id($this->id);

        $result = array();

        foreach($data as $item)
            $result[$item->age_id] = array('1' => $item->price_1, '2' => $item->price_2);

        return $result;
    }

    public function get_service_prices()
    {
        $data = PeriodServicePrice::find_all_by_period_id($this->id);

        $result = array();

        foreach($data as $item)
            $result[$item->age_id][$item->service_id] = $item->price;
        return $result;
    }
}

?>