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

    }

    private function get_days($formulars = array(), &$total)
    {
        $days_added = array();
        $result = array();

        $total = array('amount' => 0, 'count' => 0, 'person_count' => 0);

        foreach ($formulars as $formular) {
            $date = $formular->status == 'rechnung' ? $formular->rechnung_date : ($formular->status == 'angebot' ? $formular->created_date : $formular->eingangs_date);
            $date = $date->format('d/m/Y');

            if (!in_array($date, $days_added)) {
                $days_added[] = $date;
                $result[$date] = array('total' => 0, 'count' => 0, 'person_count' => 0, 'formulars' => array());
            }

            $result[$date]['count']++;
            $result[$date]['total'] += $formular->brutto;
            $result[$date]['person_count'] += $formular->person_count;
            $result[$date]['formulars'][] = $formular;

            $total['count']++;
            $total['person_count'] += $formular->person_count;
            $total['amount'] += $formular->brutto;
        }

        return $result;
    }

    private function get_total($formulars = array())
    {

        $type_stats = array(
            'pausschalreise' => array('total' => 0, 'persons' => 0, 'count' => 0),
            'bausteinreise' => array('total' => 0, 'persons' => 0, 'count' => 0),
            'nurflug' => array('total' => 0, 'persons' => 0, 'count' => 0),
        );

        foreach ($formulars as $formular)
        {
            if (!isset($type_stats[$formular->type])) continue;

            $type_stats[$formular->type]['total'] += $formular->brutto;
            $type_stats[$formular->type]['persons'] += $formular->person_count;
            $type_stats[$formular->type]['count']++;
        }


        return $type_stats;
    }

    public function daily()
    {
        $day_from = $day_to = null;
        $fields = 'all';

        if ($_POST) {
            $day_from = $this->input->post('date_from');
            $day_to = $this->input->post('date_to');

            $day_from = $day_from ? inputdate_to_mysqldate($day_from) : null;
            $day_to = $day_to ? inputdate_to_mysqldate($day_to) : null;

            $fields = isset($_POST['field']) ? $_POST['field'] : array();
        }

        $angebot_q = '(status = "angebot")';
        $eingangs_q = '(status = "eingangsmitteilung")';
        $rechnung_q = '(status = "rechnung")';

        $date_q = '(';
        $date_q .= $day_from ? '{date} >= "' . $day_from . '"' : '1';
        $date_q .= ' AND ' . ($day_to ? '{date} <= "' . $day_to . '"' : '1');
        $date_q .= ')';

        $conditions = '';

        if ($_POST) {
            $type_conditions = array();
            if (isset($_POST['is_pauschalreise'])) $type_conditions[] = 'type="pausschalreise"';
            if (isset($_POST['is_bausteinreise'])) $type_conditions[] = 'type="bausteinreise"';
            if (isset($_POST['is_nurflug'])) $type_conditions[] = 'type="nurflug"';
            $type_conditions = implode(' OR ', $type_conditions);

            $conditions .= $type_conditions ? ' AND (' . $type_conditions . ')' : ' AND 0';

            $owner_type = array();

            if (isset($_POST['is_ownertype']))
                foreach ($_POST['is_ownertype'] as $ind => $val)
                    $owner_type[] = 'owner_type = ' . $ind;

            $owner_type = implode(' OR ', $owner_type);

            $conditions .= ' AND ' . ($owner_type ? '(' . $owner_type . ')' : '0');

            if (isset($_POST['agency_num'])) {
                $agency = Kunde::find_by_k_num($this->input->post('agency_num'));
                if ($agency)
                    $conditions .= ' AND kunde_id = ' . $agency->id;
            }
        }


        $angebot_q .= ' AND ' . str_replace('{date}', 'created_date', $date_q) . $conditions;
        $eingangs_q .= ' AND ' . str_replace('{date}', 'eingangs_date', $date_q) . $conditions;
        $rechnung_q .= ' AND ' . str_replace('{date}', 'rechnung_date', $date_q) . $conditions;

        $angebots = Formular::all(array('conditions' => array($angebot_q), 'order' => 'created_date DESC'));
        $eingangs = Formular::all(array('conditions' => array($eingangs_q), 'order' => 'eingangs_date DESC'));
        $rechnungs = Formular::all(array('conditions' => array($rechnung_q), 'order' => 'rechnung_date DESC'));

        $angebot_days = $this->get_days($angebots, $angebot_total);
        $eingangs_days = $this->get_days($eingangs, $eingangs_total);
        $rechnung_days = $this->get_days($rechnungs, $rechnung_total);

        $template_data = $_POST ? array('fields' => $fields) : array();


        $template_data['days'] = $angebot_days;
        $template_data['total'] = $angebot_total;
        $this->view_data['angebot_html'] = $this->load->view('statistik/daily_angebot_list.php', $template_data, true);
        $this->view_data['angebot_total_types'] = $this->load->view('statistik/total_formular_types.php', array('type_stats' => $this->get_total($angebots)), true);

        $template_data['days'] = $eingangs_days;
        $template_data['total'] = $eingangs_total;
        $this->view_data['eingangs_html'] = $this->load->view('statistik/daily_eingangs_list.php', $template_data, true);
        $this->view_data['eingangs_total_types'] = $this->load->view('statistik/total_formular_types.php', array('type_stats' => $this->get_total($eingangs)), true);

        $template_data['days'] = $rechnung_days;
        $template_data['total'] = $rechnung_total;
        $this->view_data['rechnung_html'] = $this->load->view('statistik/daily_rechnung_list.php', $template_data, true);
        $this->view_data['rechnung_total_types'] = $this->load->view('statistik/total_formular_types.php', array('type_stats' => $this->get_total($rechnungs)), true);

        if ($_POST) {
            echo json_encode(array(
                'angebot' => $this->view_data['angebot_html'],
                'rechnung' => $this->view_data['rechnung_html'],
                'eingangs' => $this->view_data['eingangs_html'],
                'angebot_types' => $this->view_data['angebot_total_types'],
                'rechnung_types' => $this->view_data['rechnung_total_types'],
                'eingangs_types' => $this->view_data['eingangs_total_types'],
            ));
            die;
        }

        $this->view_data['page_title'] = 'Daily Statistic';
    }


    public function payment_type()
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
                $owner_type[] = 'owner_type = ' . $ind;

        $owner_type = implode(' OR ', $owner_type);

        $conditions .= ' AND ' . ($owner_type ? '(' . $owner_type . ')' : '0');

        $formulars = Formular::all(array('conditions' => array($conditions), 'order' => 'r_num_int ASC'));


        echo $this->load->view('statistik/stats_list.php', array('formulars' => $formulars, 'fields' => $fields, 'type_stats' => $type_stats), true);

        exit();
    }

}
