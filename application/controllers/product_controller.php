<?php

class Product_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        foreach(Formular::all() as $formular)
        {
            $formular->provision_date = $formular->provision2_date;
            $formular->save();
        }

        if (!$this->user)
            redirect('login');
    }

    public function index()
    {
        $this->view_data['page_title'] = 'Product';
    }

}
