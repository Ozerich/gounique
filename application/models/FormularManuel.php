<?php

class FormularManuel extends ActiveRecord\Model
{
    static $table_name = "formular_manuels";

    public function get_plain_text()
    {
        $text = '';
        $text = ($this->date_start && $this->date_end) ? $this->date_start->format('d.m.Y') . " - " . $this->date_end->format('d.m.Y') . " " : '';
        $text .=  $this->text . " - &nbsp;<b>" . $this->price . "&euro;</b>";

        return $text;
    }

    public function get_pdf_text()
    {
        $text = '';
        $text = ($this->date_start && $this->date_end) ? $this->date_start->format('d.m.Y') . " - " . $this->date_end->format('d.m.Y') . " " : '';
        $text .=  $this->text;

        return $text;
    }

    public function get_nodate_text()
    {
        $text = $this->text . " - &nbsp;<b>" . $this->price . "&euro;</b>";

        return $text;
    }

    public function get_status_logs()
    {
        return FormularStatusLog::find_all_by_item_id($this->id);
    }

    public function get_plain_status()
    {
        switch($this->status)
        {
            case 'rq':
                return 'RQ';
            case 'wl':
                return 'WL';
            case 'ok':
                return 'OK';
            default:
                return 'No status';
        }
    }

    public function get_type()
    {
        return "manuel";
    }

    public function get_date_str()
    {
        return ($this->date_start && $this->date_end) ? $this->date_start->format('d.m.Y') . ' - ' . $this->date_end->format('d.m.Y') : '';
    }

    public function get_voucher_name()
    {
        return "voucher_manuel_".$this->id.".pdf";
    }

}
