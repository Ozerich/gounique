<?php

class Product_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');
    }

    public function index()
    {
        $this->view_data['page_title'] = 'Product';
    }

}
