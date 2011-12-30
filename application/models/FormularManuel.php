<?php

class FormularManuel extends ActiveRecord\Model
{
    static $table_name = "formular_manuels";
    
    public function get_plain_text()
    {
        $text = $this->date_start->format('d.m.Y') . " - " . $this->date_end->format('d.m.Y') . " ";
        $text .=  $this->text . " - &nbsp;<b>" . $this->price . "&euro;</b>";

        return $text;
    }

    public function get_pdf_text()
    {
        $text = $this->text . " - &nbsp;<b>" . $this->price . "&euro;</b>";

        return $text;
    }
}
