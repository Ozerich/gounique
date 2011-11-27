<?php

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        if(!$this->user)
            redirect('login');
    }
}
