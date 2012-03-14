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
        $this->view_data['stats_list'] = $this->load->view('statistik/stats_list.php', array('formulars' => Formular::find_all_by_status('rechnung')), true);
        $this->view_data['page_title'] = 'Statistik';
    }

}
