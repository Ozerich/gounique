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
        if ($this->is_storno && $this->status == "rechnung")
            return "Stornorechnung";
        return strtoupper($this->status[0]) . substr($this->status, 1);
    }

    public function get_kunde()
    {
        return Kunde::find_by_id($this->kunde_id);
    }

    public function get_persons()
    {
        return FormularPerson::find_all_by_formular_id($this->storno_original && $this->is_storno ? $this->storno_original : $this->id);
    }

    public function get_hotels()
    {
        return FormularHotel::all(array(
            'conditions' => array('formular_id = ?', $this->storno_original && $this->is_storno ? $this->storno_original : $this->id),
            "order" => 'date_start asc'
        ));
    }

    public function get_manuels()
    {
        return FormularManuel::all(array(
            'conditions' => array('formular_id = ?', $this->storno_original && $this->is_storno ? $this->storno_original : $this->id),
            "order" => 'date_start asc'
        ));
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
        $manuels = $this->get_manuels();
        $list = array();
        $hotel_ind = $manuel_ind = 0;

        for (; $manuel_ind < count($manuels) && !$manuels[$manuel_ind]->date_start; $manuel_ind++) ;

        while ($hotel_ind < count($hotels) || $manuel_ind < count($manuels))
        {
            if ($hotel_ind >= count($hotels))
                $list[] = $manuels[$manuel_ind++];
            else if ($manuel_ind >= count($manuels))
                $list[] = $hotels[$hotel_ind++];
            else if ($hotels[$hotel_ind]->date_start > $manuels[$manuel_ind]->date_start)
                $list[] = $manuels[$manuel_ind++];
            else
                $list[] = $hotels[$hotel_ind++];
        }

        for ($i = 0; $i < count($manuels) && !$manuels[$i]->date_start; $i++)
            $list[] = $manuels[$i];

        return $list;
    }

    public function get_paid_amount()
    {
        $payments = $this->payments;
        $res = 0;

        foreach ($payments as $payment)
            $res += $payment->amount;

        return round($res, 2);
    }

    public function get_provisionpaid_amount()
    {
        $payments = $this->provision_payments;
        $res = 0;

        foreach ($payments as $payment)
            $res += $payment->amount;

        return $res;
    }

    public function get_brutto_price()
    {
        if ($this->type == 'nurflug')
            return ($this->flight_price + $this->service_charge) * $this->person_count;

        $hotel_price = $manuel_price = 0;

        foreach (FormularHotel::find_all_by_formular_id($this->id) as $hotel)
            $hotel_price += $hotel->all_price;

        foreach (FormularManuel::find_all_by_formular_id($this->id) as $manuel)
            $manuel_price += $manuel->price;

        $flight_price = $this->flight_price * $this->person_count;

        return $hotel_price + $manuel_price + $flight_price;
    }

    public function get_price()
    {
        $brutto = $price_data['brutto'] = $this->brutto;

        $hotels = FormularHotel::find_all_by_formular_id($this->id);

        $price_data['person'] = $this->person_count == 0 ? 0 : $brutto / $this->person_count;

        foreach ($hotels as $hotel)
            if ($hotel->people_count < $this->person_count) {
                $price_data['person'] = 0;
                break;
            }

        $price_data['provision'] = round($this->provision_amount / 1.19, 2);
        $price_data['mwst'] = $this->kunde && $this->kunde->ausland == 1 ? 0 : (round($price_data['provision'] * 0.19, 2));

        $price_data['netto'] = round($brutto - $this->provision_amount, 2);

        $price_data['anzahlung'] = $this->prepayment;
        $price_data['anzahlung_value'] = round($brutto / 100 * $this->prepayment);
        $price_data['restzahlung'] = $brutto - $price_data['anzahlung_value'];


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

    public function count_arrival_date()
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
        $data = IncomingPayment::find_all_by_formular_id($this->id);
        return $data ? $data : array();
    }

    public function get_provision_payments()
    {
        $data = ProvisionPayment::find_all_by_formular_id($this->id);
        return $data ? $data : array();
    }

    public function get_anzahlung_status()
    {
        $anzahlung = $this->prepayment_amount;

        foreach ($this->payments as $payment)
            $anzahlung -= $payment->amount;

        return $anzahlung <= 0 ? $anzahlung : -$anzahlung;
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
        return $restzahlung < 0 ? $restzahlung : -$restzahlung;
    }

    public function get_last_payment()
    {
        $last = null;

        foreach ($this->payments as $payment)
            if ($last == null || $payment->payment_date > $last->payment_date)
                $last = $payment;

        return $last;
    }


    public function get_lastprovision_payment()
    {
        $last = null;

        foreach ($this->provision_payments as $payment)
            if ($last == null || $payment->payment_date > $last->payment_date)
                $last = $payment;

        return $last;
    }

    public function get_provision_status()
    {
        $total = $this->get_provisionpaid_amount();
        return $total - $this->provision_amount;
    }

    public function get_original()
    {
        return $this->storno_original ? Formular::find(array('conditions' => array('id = ?', $this->storno_original))) : $this;
    }

    public function get_versanded_user()
    {
        return User::find_by_id($this->versanded_by);
    }

    public function get_invoices()
    {
        $data = Invoice::find_all_by_formular_id($this->id);
        return $data ? $data : array();
    }

    public function get_incomings()
    {
        $incomings = $added = array();

        foreach ($this->hotels_and_manuels as $item)
            if ($item->incoming_id) {
                if (!isset($added[$item->incoming_id])) {
                    $added[$item->incoming_id] = count($incomings);
                    $incomings[] = Incoming::find_by_id($item->incoming_id);
                }
                //  $incomings[$added[$item->incoming_id]]->amount += $item->all_price;
            }

        return $incomings;
    }

    public function get_invoice_stats()
    {
        $data = array('hotel' => array(), 'transfer' => array(), 'flight' => array(), 'rundreise' => array(), 'total' => array(), 'other' => array());
        foreach ($data as &$item)
            $item = array('paid' => 0, 'amount' => 0, 'status' => 0);


        foreach ($this->invoices as $invoice)
        {
            $type = substr($invoice->type, 0, strlen('flight')) == "flight" ? "flight" : $invoice->type;
            $data[$type]['paid'] += $invoice->paid_amount;
            $data[$type]['amount'] += $invoice->amount;
            $data['total']['paid'] += $invoice->paid_amount;
            $data['total']['amount'] += $invoice->amount;
        }

        foreach ($data as &$type)
            $type['status'] = $type['amount'] > $type['paid'] ? '-' . ($type['amount'] - $type['paid']) : '+' . ($type['paid'] - $type['amount']);

        return $data;
    }

    public function get_person()
    {
        $persons = $this->persons;
        return $persons ? $persons[0]->name : "NO";
    }

    public function get_total_diff()
    {
        if ($this->status == "gutschrift")
            return 0;

        $total = $this->get_paid_amount();
        return round($total - $this->brutto, 2);
    }


    public function get_gutschrift()
    {
        if ($this->status == "rechnung")
            return Formular::find(array('conditions' => array('status = "gutschrift" AND storno_original = ?', $this->storno_original)));
        if ($this->status == "gutschrift")
            return $this;
        if ($this->status == "storno")
            return Formular::find(array('conditions' => array('status = "gutschrift" AND is_storno = 1 AND storno_original = ?', $this->id)));


    }

    public function get_storno_rechnung()
    {
        if ($this->status == "gutschrift")
            return Formular::find(array('conditions' => array('status = "rechnung" AND is_storno = 1 AND storno_original = ?', $this->storno_original)));
        if ($this->status == "storno")
            return Formular::find(array('conditions' => array('status = "rechnung" AND is_storno = 1 AND storno_original = ?', $this->id)));

    }

    public function get_flight_invoices()
    {
        return FlightInvoice::find_all_by_formular_id($this->id);
    }

    public function get_flight_stats(){
        $result = array('amount' => 0, 'paid' => 0, 'status' => 0);

        foreach($this->flight_invoices as $invoice)
        {
            $result['amount'] = $invoice->amount;
            $result['paid'] = $invoice->paid_amount;
            $result['status'] = $invoice->status;
        }

        return $result;
    }

}

?>