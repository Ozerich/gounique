<?php

class Agency_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('date');

        $this->view_data['JS_files'] = array("js/agency.js");
    }

    public function create()
    {
        if ($_POST) {
            $p = $this->input->post('type') == "agency" ? "a_" : "k_";
            $agency = Agency::create(
                array(
                     "type" => $this->input->post('type'),
                     "name" => $this->input->post($p.'name'),
                     "date_created" => mdate("%Y-%m-%d"),
                     "person_name" => $this->input->post($p.'person_name'),
                     "person_surname" => $this->input->post($p.'person_surname'),
                     "address" => $this->input->post($p.'address'),
                     "plz" => $this->input->post($p.'plz'),
                     "ort" => $this->input->post($p.'ort'),
                     "website" => $this->input->post($p.'website'),
                     "sex" => $this->input->post($p.'sex') == "herr" ? "man" : "woman",
                     "email" => $this->input->post($p.'email'),
                     "phone" => $this->input->post($p.'phone'),
                     "fax" => $this->input->post($p.'fax'),
                     "provision" => $this->input->post($p.'provision'),
                     "about" => $this->input->post($p.'about'),
                ));

            if($agency)
                redirect('agency/'.$agency->id);
        }

        $this->set_page_title("New agency");
    }

    public function view($id)
    {
        $agency = Agency::find_by_id($id);
        if($agency)
        {
            $this->view_data['formulars'] = Formular::all(array('conditions' => array('k_num = ?', $id)));
            $this->view_data['agency'] = $agency;

            $this->set_page_title("Agency: ".$agency->name);
        }
        else
            show_404();
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {

            $agency = Agency::find_by_id($this->input->post("agency_id"));

            if(!$agency)
                show_404();

            $agency->name = $this->input->post("name");
            $agency->address = $this->input->post("address");
            $agency->plz = $this->input->post("plz");
            $agency->ort = $this->input->post("ort");
            $agency->website = $this->input->post("website");
            $agency->sex = $this->input->post("sex") == "herr" ? "man" : "woman";
            $agency->person_name = $this->input->post("person_name");
            $agency->person_surname = $this->input->post("person_surname");
            $agency->email = $this->input->post("email");
            $agency->phone = $this->input->post("phone");
            $agency->fax = $this->input->post("fax");
            $agency->provision = $this->input->post("provision");
            $agency->about = $this->input->post("about");

            $agency->save();

            redirect('agency/'.$agency->id);

        }

        $agency = Agency::find($id);
        $this->view_data['agency'] = $agency;
    }

}
