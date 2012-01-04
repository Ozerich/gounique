<?php

class Kundenverwaltung_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->set_page_title("Kundenverwaltung");
    }

    public function agenturen()
    {

        $this->set_page_title("Agenturen Liste");
    }

    public function incoming()
    {

        $this->set_page_title("Incoming Liste");
    }

    public function stammkunden()
    {

        $this->set_page_title("Stammkunden Liste");
    }

    public function mitarbeiter()
    {

        $this->set_page_title("Mitarbeiter Liste");
    }


}
