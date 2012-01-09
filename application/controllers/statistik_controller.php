<?php

class Statistik_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if(!$this->user)
            redirect('login');

        $this->view_data['JS_files'] = array("js/statistik.js");
    }

    public function index()
    {
        $this->view_data['formulars'] = Formular::all();

        $this->view_data['page_title'] = 'Statistik';
    }

    public function count_brutto()
    {
        $date_start = inputdate_to_mysqldate($this->input->post('date_start'));
        $date_end = inputdate_to_mysqldate($this->input->post('date_end'));

        $result = 0;

        $formulars = Formular::find('all', array('conditions' => array('created_date >= ? AND created_date <= ?', $date_start, $date_end)));

        foreach($formulars as $formular)
            $result += $formular->price['brutto'];

        echo $result;
        exit();
    }
}
