<?php

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if(!$this->user)
            redirect('login');
    }

    public function index()
    {

        $this->view_data['agency_list'] = Agency_model::all();

        $this->view_data['page_name'] = 'formular-list';

        $this->view_data['JS_files'] = array("js/agency.js");

    }
}
