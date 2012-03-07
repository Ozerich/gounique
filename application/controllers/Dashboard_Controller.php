<?php

class Dashboard_Controller extends MY_Controller
{

    public function convert()
    {
    }

    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');

    }

    public function index()
    {
        $this->view_data['page_title'] = 'Dashboard';
    }
}
