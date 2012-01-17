<?php

class Dashboard_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');

        User::create(array(
            'name' => 'Ozgun',
            'surname' => 'Dogan',
            'email' => 'ozgun.dogan@unique-world.de',
            'password' => 'bvb01*'
        ));

        User::create(array(
            'name' => 'Karina',
            'surname' => 'Beckmann',
            'email' => 'karina.beckmann@unique-world.de',
            'password' => '!34Ln#9D'
        ));

        User::create(array(
            'name' => 'Wladislav',
            'surname' => 'Wanscheid',
            'email' => 'wladislav.wanscheid@unique-world.de',
            'password' => 'wlad2011'
        ));
    }

    public function index()
    {
        $this->view_data['page_title'] = 'Dashboard';
    }
}
