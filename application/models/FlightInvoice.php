<?php

class FlightInvoice extends ActiveRecord\Model
{
    static $table_name = "flight_invoices";

    static $TYPES = array(
        '1' => 'AER-Das Ticket Team',
        '2' => 'Charter Direkt',
        '3' => 'Charter über Reisebüro',
        '4' => 'LowCost',
        '5' => 'Other');

    public function get_payments()
    {
        $data = FlightPayment::find_all_by_invoice_id($this->id);
        return $data ? $data : array();
    }

    public function get_plain_type()
    {
        return isset(FlightInvoice::$TYPES[$this->type]) ? FlightInvoice::$TYPES[$this->type] : 'Unknown';
    }

    public function get_created_user()
    {
        return User::find_by_id($this->created_by);
    }

    public function get_paid_amount()
    {
        $result = 0;
        foreach ($this->payments as $payment)
            $result += $payment->amount;
        return $result;
    }

    public function get_status()
    {
        return $this->paid_amount - $this->amount;
    }

}