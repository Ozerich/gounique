<?php

class Agency extends MY_Controller
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
            $agency = Agency_model::create(
                array(
                     "type" => $this->input->post('type'),
                     "name" => $this->input->post($p.'name'),
                     "datecreated" => mdate("%Y-%m-%d"),
                     "surname" => $this->input->post($p.'surname'),
                     "address" => $this->input->post($p.'address'),
                     "plz" => $this->input->post($p.'plz'),
                     "ort" => $this->input->post($p.'ort'),
                     "website" => $this->input->post($p.'website'),
                     "sex" => $this->input->post($p.'sex'),
                     "contactperson" => $this->input->post($p.'contactperson'),
                     "email" => $this->input->post($p.'email'),
                     "phone" => $this->input->post($p.'phone'),
                     "fax" => $this->input->post($p.'fax'),
                     "provision" => $this->input->post($p.'provision'),
                     "comment" => $this->input->post($p.'comment'),
                ));
            if($agency)
                redirect('agency/'.$agency->id);
        }
    }

    public function view($id)
    {
        $agency = Agency_model::find_by_id($id);
        if($agency)
        {
            $this->view_data['formulars'] = Formular::all();
            $this->view_data['agency'] = $agency;
        }
        else
            show_404();
    }

    public function edit($id = FALSE)
    {
        if ($_POST) {

            $agency = Agency_model::find_by_id($this->input->post("agency_id"));

            if(!$agency)
                show_404();

            $agency->name = $this->input->post("name");
            $agency->surname = $this->input->post("surname");
            $agency->address = $this->input->post("address");
            $agency->plz = $this->input->post("plz");
            $agency->ort = $this->input->post("ort");
            $agency->website = $this->input->post("website");
            $agency->sex = $this->input->post("sex");
            $agency->contactperson = $this->input->post("contactperson");
            $agency->email = $this->input->post("email");
            $agency->phone = $this->input->post("phone");
            $agency->fax = $this->input->post("fax");
            $agency->provision = $this->input->post("provision");
            $agency->comment = $this->input->post("comment");

            $agency->save();

            redirect('agency/'.$agency->id);

        }

        $agency = Agency_model::find($id);
        $this->view_data['agency'] = $agency;
    }

}
