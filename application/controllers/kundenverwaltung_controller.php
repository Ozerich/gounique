<?php

class Kundenverwaltung_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->set_page_title("Kundenverwaltung");
    }

    private function get_knum($type)
    {
        switch($type)
        {
            case 'agenturen':
                return 'A0001';

            case 'incoming':
                return 'I0001';

            case 'mitarbeiter':
                return 'M0001';

            case 'stammkunden':
                return 'S0001';
        }

        return "";
    }


    public function buchen($id = 0)
    {
        redirect("reservierung/create/".$id);
    }

    public function historie($id = 0)
    {
        $client = Kunde::find_by_id($id);

        if(!$client)
        {
            show_404();
            return false;
        }

        $this->view_data['kunde'] = $client;

    }

    public function verwalten($id = 0)
    {
        $client = Kunde::find_by_id($id);

        if(!$client)
        {
            show_404();
            return false;
        }

        if($_POST)
        {

            $client->name = $this->input->post('name');
            $client->address = $this->input->post('address');
            $client->plz = $this->input->post('plz');
            $client->ort = $this->input->post('ort');
            $client->website = $this->input->post('website');
            $client->sex = $this->input->post('sex');
            $client->person_name = $this->input->post('person_name');
            $client->person_surname = $this->input->post('person_surname');
            $client->email = $this->input->post('email');
            $client->phone = $this->input->post('phone');
            $client->fax = $this->input->post('fax');
            $client->provision = $this->input->post('provision');
            $client->about = $this->input->post('about');

            $client->save();

            redirect('/'.$client->type);
        }

        $this->view_data['kunde'] = $client;
    }

    public function new_($type = "")
    {

        if($_POST)
        {
            $params = array(
                "k_num" => $this->get_knum($type),
                "type" => $type,
                "created_date" => time_to_mysqldate(time()),
                "name" => $this->input->post("name"),
                "address" => $this->input->post("address"),
                "plz" => $this->input->post("plz"),
                "ort" => $this->input->post("ort"),
                "website" => $this->input->post("website"),
                "sex" => $this->input->post("sex"),
                "person_name" => $this->input->post("person_name"),
                "person_surname" => $this->input->post("person_surname"),
                "email" => $this->input->post("email"),
                "phone" => $this->input->post("phone"),
                "fax" => $this->input->post("fax"),
                "provision" => $this->input->post("provision"),
                "about" => $this->input->post("about"));

            Kunde::create($params);

            redirect('/'.$type);
        }

        $this->set_page_tpl($type);
    }

    public function agenturen($action = "")
    {
        $this->view_data['search_text'] = '';

        if($action == "search")
        {
            if($_POST)
            {
                $this->view_data['search_text'] = $this->input->post('search_text');
                $s = $this->input->post('search_text');
                $this->view_data['items'] = Kunde::find('all', array('conditions' => array('k_num like "%'.$s.'%" OR name like "%'.$s.'%"')));
            }
        }
        else
            $this->view_data['items'] = Kunde::find_all_by_type('agenturen');

        $this->set_page_title("Agenturen Liste");
    }

    public function incoming($action = "")
    {

        $this->set_page_title("Incoming Liste");
    }

    public function stammkunden($action = "")
    {

        $this->set_page_title("Stammkunden Liste");
    }

    public function mitarbeiter($action = "")
    {

        $this->set_page_title("Mitarbeiter Liste");
    }


}
