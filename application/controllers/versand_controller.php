<?php

class Versand_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');

        $this->view_data['JS_files'] = array("js/control.js");
    }

    public function index()
    {
        $formulars = Formular::all(array('conditions' => 'status="rechnung"', 'order' => 'departure_date DESC'));
        $this->view_data['invoice_list'] = $this->load->view('versand/invoice_list.php',
            array('formulars' => $formulars), true);

        $this->view_data['page_title'] = 'Versand';
    }

    public function search()
    {
        $search_field = $this->input->post('search_field');
        $search_string = $this->input->post('search_string');

        $von = inputdate_to_mysqldate($this->input->post('von'));
        $bis = inputdate_to_mysqldate($this->input->post('bis'));

        $person_filter = strtoupper($this->input->post('person'));

        $kunde = $this->input->post('ag_num') ? Kunde::find_by_k_num($this->input->post('ag_num')) : 0;
        $kunde_query = $kunde ? ' AND kunde_id="' . $kunde->id . '"' : '';


        $formulars = array();
        if ($search_string)
            $formulars = Formular::find('all', array('conditions' =>
            array('(status = "rechnung" OR status = "storno") ' . $kunde_query . ' AND ' . $search_field . ' like "%' . $search_string . '%"'), 'order' => 'departure_date DESC'));
        else if ($von && $bis) {
            $search_map = array(
                'buchung' => 'created_date',
                'rechnung' => 'rechnung_date',
                'abreise' => 'departure_date',
                'anzahlung' => 'prepayment_date',
                'restzahlung' => 'finalpayment_date',
                'provision' => 'provision_date',
                'versand' => 'versanded_date'
            );

            if (isset($search_map[$search_field])) {
                $search_field = $search_map[$search_field];
                $formulars = Formular::find('all', array('conditions' =>
                array('(status = "rechnung" OR status = "storno" )' . $kunde_query . ' AND ' . $search_field . ' >= ? AND ' . $search_field . ' <= ?', $von, $bis), 'order' => 'departure_date DESC'));
            }
        }
        else
            $formulars = Formular::all(array(
                    'conditions' => array('(status = "rechnung" OR status = "storno")' . $kunde_query),
                    'order' => 'departure_date DESC')
            );
        $result = array();

        foreach ($formulars as $formular)
        {
            if ($person_filter && strpos($formular->person, $person_filter) === false)
                continue;
            $result[] = $formular;
        }


        echo $this->load->view('versand/invoice_list.php', array('formulars' => $result), true);
        die;
    }
}
