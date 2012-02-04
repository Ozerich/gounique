<?php

class Dashboard_Controller extends MY_Controller
{

    public function convert()
    {
        $base = array();
        if (($handle = fopen("E:/hotel.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if(in_array($data[3], $base))
                    continue;
                Hotel::create(array(
                    'tlc' => $data[2],
                    'code' => $data[3],
                    'ort' => $data[6],
                    'name' => $data[7],
                    'stars' => $data[8]
                ));
                $base[] = $data[3];
            }
            fclose($handle);
        }

    }

    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');

        $this->convert();
    }

    public function index()
    {
        $this->view_data['page_title'] = 'Dashboard';
    }
}
