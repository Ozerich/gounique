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
        return FormularHotel::all(array(
            'conditions' => array('formular_id = ?', $this->id),
            "order" => 'date_start asc'
        ));
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
            $hotel_price += $hotel->all_price;

        $manuel_price = 0;
        $manuels = FormularManuel::find_all_by_formular_id($this->id);

        foreach ($manuels as $manuel)
            $manuel_price += $manuel->price;

        $flight_price = $this->flight_price * $this->person_count;

        $price = $hotel_price + $manuel_price + $flight_price;

        $price_data = array();

        $price_data['brutto'] = $price;

        $price_data['person'] = $this->person_count == 0 ? 0 : $price_data['brutto'] / $this->person_count;

        foreach ($hotels as $hotel)
            if ($hotel->people_count < $this->person_count) {
                $price_data['person'] = 0;
                break;
            }

        $price_data['provision'] = round($price_data['brutto'] * $this->provision / 100, 2);
        $price_data['mwst'] = $this->kunde && $this->kunde->ausland == 1 ? 0 : (round($price_data['provision'] * 0.19, 2));

        $price_data['total_provision'] = $price_data['provision'] + $price_data['mwst'];

        $price_data['netto'] = round($price_data['brutto'] - $price_data['total_provision'], 2);

        $price_data['anzahlung'] = $this->prepayment;
        $price_data['anzahlung_value'] = round($price_data['brutto'] / 100 * $this->prepayment);
        $price_data['restzahlung'] = $price_data['brutto'] - $price_data['anzahlung_value'];


        if ($this->status == "storeno") {
            $price_data['storeno_sum'] = $this->storeno->percent / 100 * $price_data['brutto'];
            $price_data['gutschriftsbetrag'] = $price_data['brutto'] - $price_data['storeno_sum'];
            if ($this->kunde->type == "agenturen") {
                $price_data['storeno_provision'] = $this->kunde->provision / 100 * $price_data['storeno_sum'];
                $price_data['storeno_mwst'] = $this->kunde->ausland == 1 ? 0 : $price_data['storeno_provision'] * 0.19;
                $price_data['gesamtprovision'] = $price_data['storeno_mwst'] + $price_data['storeno_provision'];
            }
        }

        foreach ($price_data as &$val)
            $val = number_format($val, 2, ',', '.');

        return $price_data;
    }

    public function get_can_rechnung()
    {
        $noneok = FormularHotel::find('all', array('conditions' => array('formular_id = ? and status != ?', $this->id, 'ok')));
        return $noneok == null;
    }

    public function get_storeno()
    {
        if ($this->status != "storeno")
            return NULL;

        return FormularStorno::find_by_formular_id($this->id);
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

    public function get_plain_persons()
    {
        $persons = FormularPerson::find_all_by_formular_id($this->id);
        $text = "";
        if ($persons)
            foreach ($persons as $person)
                $text .= $person->name . " " . $person->surname . ", ";

        return $text ? substr($text, 0, -2) : "";
    }

    public function get_is_sofort()
    {
        if ($this->prepayment_date && $this->prepayment_amount > 0)
            return false;
        return true;
    }

    public function get_sachbearbeiter()
    {
        return User::find_by_id($this->created_by);
    }

    public function get_payments()
    {
        $data = FormularPayment::find_all_by_formular_id($this->id);
        return $data ? $data : array();
    }

    public function get_anzahlung_status()
    {
        $anzahlung = $this->prepayment_amount;

        foreach ($this->payments as $payment)
            $anzahlung -= $payment->amount;

        return ($anzahlung <= 0) ? "OK" : "-" . $anzahlung;
    }

    public function get_restzahlung_status()
    {
        $restzahlung = $this->finalpayment_amount;
        $anzahlung = $this->prepayment_amount;

        foreach ($this->payments as $payment)
        {
            if ($anzahlung > 0) {
                $anzahlung -= $payment->amount;

                if ($anzahlung < 0) {
                    $restzahlung += $anzahlung;
                    $anzahlung = 0;
                }
                continue;
            }
            $restzahlung -= $payment->amount;
        }

        return ($restzahlung <= 0) ? "OK" : "-" . $restzahlung;
    }

    public function get_last_payment()
    {
        $last = null;

        foreach($this->payments as $payment)
            if($last == null || $payment->payment_date > $last->payment_date)
                $last = $payment;

        return $last;
    }

    public function get_payment_status()
    {
        $total = 0;

        foreach($this->payments as $payment)
            $total += $payment->amount;

        if($total > $this->brutto)
            return "+".($total - $this->brutto);
        else if($total < $this->brutto)
            return "-".($this->brutto - $total);
        else
            return "OK";
    }

}

?>