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
        $formulars = Formular::all(array('conditions' => array('status = "rechnung"'), 'order' => 'r_num_int ASC'));

        $type_stats = array(
            'pausschalreise' => array('total' => 0, 'persons' => 0, 'count' => 0),
            'bausteinreise' => array('total' => 0, 'persons' => 0, 'count' => 0),
            'nurflug' => array('total' => 0, 'persons' => 0, 'count' => 0),
        );

        foreach ($formulars as $formular)
        {
            $type_stats[$formular->type]['total'] += $formular->brutto;
            $type_stats[$formular->type]['persons'] += $formular->person_count;
            $type_stats[$formular->type]['count']++;
        }

        $this->view_data['stats_list'] = $this->load->view('statistik/stats_list.php', array('formulars' => $formulars, 'type_stats' => $type_stats), true);
        $this->view_data['page_title'] = 'Statistik';
    }


    public function search()
    {
        $fields = isset($_POST['field']) ? $_POST['field'] : array();

        $conditions = 'status = "rechnung"';
        $type_conditions = array();
        if (isset($_POST['is_pauschalreise'])) $type_conditions[] = 'type="pausschalreise"';
        if (isset($_POST['is_bausteinreise'])) $type_conditions[] = 'type="bausteinreise"';
        if (isset($_POST['is_nurflug'])) $type_conditions[] = 'type="nurflug"';
        $type_conditions = implode(' OR ', $type_conditions);

        $conditions .= $type_conditions ? ' AND (' . $type_conditions . ')' : ' AND 0';

        if (isset($_POST['from-date']) && isset($_POST['to-date']) && isset($_POST['search-type'])) {
            $from = inputdate_to_mysqldate($this->input->post('from-date'));
            $to = inputdate_to_mysqldate($this->input->post('to-date'));

            $type = $this->input->post('search-type');
            if ($from && $to && $type) {
                if ($type == "departure") $field = "departure_date";
                else if ($type == "arrival") $field = "arrival_date";

                $conditions .= ' AND ' . $field . ' >= "' . $from . '" AND ' . $field . ' <= "' . $to . '"';
            }
        }

        if (isset($_POST['agency_num'])) {
            $agency = Kunde::find_by_k_num($this->input->post('agency_num'));
            if ($agency)
                $conditions .= ' AND kunde_id = ' . $agency->id;
        }

        $owner_type = array();

        if (isset($_POST['is_ownertype']))
            foreach ($_POST['is_ownertype'] as $ind => $val)
                $owner_type[] = 'owner_type = '.$ind;

        $owner_type = implode(' OR ', $owner_type);

        $conditions .= ' AND '.($owner_type ? '('.$owner_type.')' : '0');

        $formulars = Formular::all(array('conditions' => array($conditions), 'order' => 'r_num_int ASC'));

        $type_stats = array(
            'pausschalreise' => array('total' => 0, 'persons' => 0, 'count' => 0),
            'bausteinreise' => array('total' => 0, 'persons' => 0, 'count' => 0),
            'nurflug' => array('total' => 0, 'persons' => 0, 'count' => 0),
        );

        foreach ($formulars as $formular)
        {
            $type_stats[$formular->type]['total'] += $formular->brutto;
            $type_stats[$formular->type]['persons'] += $formular->person_count;
            $type_stats[$formular->type]['count']++;
        }

        echo $this->load->view('statistik/stats_list.php', array('formulars' => $formulars, 'fields' => $fields, 'type_stats' => $type_stats), true);

        exit();
    }

}
