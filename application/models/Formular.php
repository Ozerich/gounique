<?php

class Formular extends ActiveRecord\Model
{
    static $table_name = "formulars";

    public function get_date()
    {
        return substr($this->zahlungsdatum, 0, 2) . "." . substr($this->zahlungsdatum, 2, 2) . "." . substr($this->zahlungsdatum, 4);
    }

    public function get_plain_status()
    {
        return strtoupper($this->status[0]) . substr($this->status, 1);
    }

    public function get_kunde()
    {
        return Kunde::find_by_id($this->kunde_id);
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

    public function get_adult_count()
    {
        return FormularPerson::count(array('conditions' => array('formular_id = ? and (sex = ? or sex = ?)', $this->id, 'herr', 'frau')));
    }

    public function get_child_count()
    {
        return FormularPerson::count(array('conditions' => array('formular_id = ? and sex = ?', $this->id, 'child')));
    }

    public function get_infant_count()
    {
        return FormularPerson::count(array('conditions' => array('formular_id = ? and sex = ?', $this->id, 'infant')));
    }

    public function get_hotels_and_manuels()
    {
        $hotels = $this->get_hotels();

        foreach ($this->get_manuels() as $manuel)
            $hotels[] = $manuel;

        return $hotels;
    }

    public function get_payments()
    {
        return FormularPayment::find_all_by_formular_id($this->id);
    }

    public function get_paid_amount()
    {
        $payments = $this->payments;
        $res = 0;

        foreach ($payments as $payment)
            $res += $payment->value;

        return $res;
    }

    public function get_price()
    {
        $hotel_price = 0;
        $hotels = FormularHotel::find_all_by_formular_id($this->id);

        foreach ($hotels as $hotel)
            $hotel_price += $hotel->price;

        $manuel_price = 0;
        $manuels = FormularManuel::find_all_by_formular_id($this->id);

        foreach ($manuels as $manuel)
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

    public function get_can_rechnung()
    {
        $noneok = FormularHotel::find('all', array('conditions' => array('formular_id = ? and status != ?', $this->id, 'ok')));
        return $noneok == null;
    }

    public function get_arrival_date()
    {
        $hotels = Formular::get_hotels_and_manuels();

        if (!$hotels)
            return null;

        $current = 0;
        $result = null;

        foreach ($hotels as $ind => $hotel)
            if ($hotel->date_end && mysqldate_to_timestamp($hotel->date_end->format('Y-m-d')) > $current) {
                $current = mysqldate_to_timestamp($hotel->date_end->format('Y-m-d'));
                $result = $hotel->date_end;
            }

        return $result;
    }

}

?>