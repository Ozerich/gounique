<?php

class Invoice extends ActiveRecord\Model
{
    static $table_name = "invoices";

    public function get_payments()
    {
        $data = InvoicePayment::find_all_by_invoice_id($this->id);
        return $data ? $data : array();
    }

    public function get_status()
    {
        $total = 0;

        foreach($this->payments as $payment)
            $total += $payment->payment_amount;

        return $this->amount <= $total ? "OK" : '-'.num($this->amount - $total).' &euro;';
    }

    public function get_paid_amount(){
        $result = 0;
        foreach($this->payments as $payment)
            $result += $payment->payment_amount;
        return $result;
    }

    public function get_formular(){
        return Formular::find_by_id($this->formular_id);
    }
}