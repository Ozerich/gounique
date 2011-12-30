<?php

class Formular extends ActiveRecord\Model
{
    static $table_name = "formulars";

    public function get_date()
    {
        return substr($this->zahlungsdatum, 0, 2) . "." . substr($this->zahlungsdatum, 2, 2) . "." . substr($this->zahlungsdatum, 4);
    }

    public function get_agency()
    {
        return Agency::find_by_id($this->agency_id);
    }

    public function get_persons()
    {
        return FormularPerson::find_all_by_formular_id($this->id);
    }

    public function get_hotels()
    {
        return FormularHotel::find_all_by_formular_id($this->id);
    }

    public function get_manuels()
    {
        return FormularManuel::find_all_by_formular_id($this->id);
    }

    public function get_hotels_and_manuels()
    {
        $hotels = $this->get_hotels();

        foreach($this->get_manuels() as $manuel)
            $hotels[] = $manuel;

        return $hotels;
    }

    public function get_price()
    {
        $hotel_price = 0;
        $hotels = FormularHotel::find_all_by_formular_id($this->id);

        foreach ($hotels as $hotel)
            $hotel_price += $hotel->price;

        $manuel_price = 0;
        $manuels = FormularManuel::find_all_by_formular_id($this->id);

        foreach($manuels as $manuel)
            $manuel_price += $manuel->price;

        $price = $hotel_price;
        $price += $this->flight_price;
        $price = $price * $this->person_count;

        $price_data = array();

        $price_data['brutto'] = $price + $manuel_price;

        $price_data['person'] = $this->person_count == 0 ? 0 : $price_data['brutto'] / $this->person_count;


        $price_data['provision'] = round($price_data['brutto'] * $this->provision / 100, 2);
        $price_data['mwst'] = round($price_data['provision'] * 0.019, 2);
        $price_data['total_provision'] = $price_data['provision'] + $price_data['mwst'];

        $price_data['netto'] = round($price_data['brutto'] - $price_data['total_provision'], 2);

        $price_data['anzahlung'] = $this->prepayment;
        $price_data['anzahlung_value'] = round($price_data['brutto'] / 100 * $this->prepayment);

        return $price_data;
    }

}

?>