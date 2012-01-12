<?php

class Statistik_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
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

        foreach ($formulars as $formular)
            $result += $formular->price['brutto'];

        echo $result;
        exit();
    }

    public function main()
    {
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];

        $start = $limit*$page - $limit;

        $formulars = Formular::all(array("order" => $sidx." ".$sord, "limit" => $limit, "offset" => $start));


        $responce = null;
        $responce->records = count($formulars);

        if ($responce->records > 0) {
            $total_pages = ceil($responce->records / $limit);
        } else {
            $total_pages = 0;
        }
        if ($page > $total_pages) $page = $total_pages;

        $responce->page = $page;
        $responce->total = $total_pages;

        foreach ($formulars as $ind => $formular)
        {
            $responce->rows[$ind]['id'] = $formular->id;
            $responce->rows[$ind]['cell'] = array(
                $formular->id,
                $formular->sachbearbeiter,
                $formular->kunde->k_num,
                $formular->kunde->name,
                $formular->provision,
                $formular->v_num,
                $formular->r_num,
                $formular->created_date->format('d.m.y'),
                $formular->rechnung_date ? $formular->rechnung_date->format('d.m.y') : '',
                $formular->plain_persons,
                $formular->departure_date ? $formular->departure_date->format('d.m.y') : '',
                $formular->arrival_date ? $formular->arrival_date->format('d.m.y') : '',
                $formular->price['brutto'],
            );
        }

        echo json_encode($responce);
        exit();
    }
}
