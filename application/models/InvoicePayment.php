<?php

class InvoicePayment extends ActiveRecord\Model
{
    static $table_name = "invoice_payments";

    public function get_plain_type()
    {
        switch ($this->payment_type) {
            case 'uberweisung':
                return 'Uberweisung';
            case 'kreditkart':
                return 'KK über UW';
            case 'kreditkart_aer':
                return 'KK über AER';
            case 'lastschrift':
                return 'Lastschrift';
            case 'bar':
                return 'Bar';
            default:
                return 'Unknown';
        }
    }

    public function get_invoice(){
        return Invoice::find_by_id($this->invoice_id);
    }
}
