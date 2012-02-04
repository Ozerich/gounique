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

    private function add_zero($kunde_num)
    {
        if($kunde_num < 10)
            return "000".$kunde_num;
        else if($kunde_num < 100)
            return "00".$kunde_num;
        else if($kunde_num < 1000)
            return "0".$kunde_num;
        return $kunde_num;
    }

    private function get_first_letter($type)
    {
        switch($type)
        {
            case "agenturen":
                return "A";
            case "stammkunden":
                return "S";
            case "incoming":
                return "I";
            case "mitarbeiter":
                return "M";
        }
        return "";
    }

    private function get_knum($type)
    {
        $kunde = Kunde::find(array(
            'conditions' => array('type=?', $type),
            'order' => 'k_num desc',
            'limit' => 1));

        $kunde_num = $kunde ? $this->add_zero(substr($kunde->k_num, 1) + 1) : $this->get_first_letter($type)."0001";

        return $kunde ? substr($kunde->k_num, 0, 1).$kunde_num : $kunde_num;

    }


    public function buchen($id = 0)
    {
        redirect("reservierung/create/" . $id);
    }

    public function historie($id = 0)
    {
        $client = Kunde::find_by_id($id);

        if (!$client) {
            show_404();
            return false;
        }

        $this->view_data['kunde'] = $client;

    }

    public function verwalten($id = 0)
    {
        $client = Kunde::find_by_id($id);

        if (!$client) {
            show_404();
            return false;
        }

        if ($_POST) {

            $client->name = $this->input->post('name');
            $client->address = $this->input->post('address');
            $client->plz = $this->input->post('plz');
            $client->ort = $this->input->post('ort');
            $client->website = $this->input->post('website');
            $client->sex = $this->input->post('sex');
            $client->person_name = $this->input->post('person_name');
            $client->email = $this->input->post('email');
            $client->phone = $this->input->post('phone');
            $client->mobile = $this->input->post('mobile');
            $client->fax = $this->input->post('fax');
            $client->provision = $this->input->post('provision');
            $client->about = $this->input->post('about');
            $client->kurzel = $this->input->post('kurzel');
            $client->ausland = $this->input->post('ausland');

            $client->k_num = $this->input->post('k_num');

            $client->save();

            redirect('/' . $client->type);
        }

        $this->view_data['kunde'] = $client;
        $this->set_page_tpl($client->type);
    }

    public function new_($type = "")
    {

        if ($_POST) {
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
                "email" => $this->input->post("email"),
                "phone" => $this->input->post("phone"),
                "fax" => $this->input->post("fax"),
                "provision" => $this->input->post("provision"),
                "about" => $this->input->post("about"),
                "ausland" => $this->input->post("ausland"),
                "kurzel" => $this->input->post("kurzel")
            );

            Kunde::create($params);

            redirect('/' . $type);
        }

        $this->set_page_tpl($type);
    }

    public function agenturen($action = "")
    {
        $this->view_data['search_text'] = '';
        if ($action == "search") {
            if ($_POST) {
                $this->view_data['search_text'] = $this->input->post('search_text');
                $s = $this->input->post('search_text');
                $this->view_data['items'] = Kunde::find('all', array('conditions' => array('k_num like "%' . $s . '%" OR name like "%' . $s . '%" AND type=?', 'agenturen')));
            }

        }
        else
            $this->view_data['items'] = Kunde::find_all_by_type('agenturen');

        $this->set_page_title("Agenturen Liste");
    }

    public function incoming($action = "")
    {
        $this->view_data['search_text'] = '';
        if ($action == "search") {
            if ($_POST) {
                $this->view_data['search_text'] = $this->input->post('search_text');
                $s = $this->input->post('search_text');
                $this->view_data['items'] = Kunde::find('all', array('conditions' => array('k_num like "%' . $s . '%" OR name like "%' . $s . '%" AND type=?', 'incoming')));
            }

        }
        else
            $this->view_data['items'] = Kunde::find_all_by_type('incoming');
        $this->set_page_title("Incoming Liste");
    }

    public function stammkunden($action = "")
    {
        $this->view_data['search_text'] = '';
        if ($action == "search") {
            if ($_POST) {
                $this->view_data['search_text'] = $this->input->post('search_text');
                $s = $this->input->post('search_text');
                $this->view_data['items'] = Kunde::find('all', array('conditions' => array('k_num like "%' . $s . '%" OR name like "%' . $s . '%" AND type=?', 'stammkunden')));
            }

        }
        else
            $this->view_data['items'] = Kunde::find_all_by_type('stammkunden');
        $this->set_page_title("Stammkunden Liste");
    }

    public function mitarbeiter($action = "")
    {
        $this->view_data['search_text'] = '';
        if ($action == "search") {
            if ($_POST) {
                $this->view_data['search_text'] = $this->input->post('search_text');
                $s = $this->input->post('search_text');
                $this->view_data['items'] = Kunde::find('all', array('conditions' => array('k_num like "%' . $s . '%" OR name like "%' . $s . '%" AND type=?', 'mitarbeiter')));
            }

        }
        else
            $this->view_data['items'] = Kunde::find_all_by_type('mitarbeiter');
        $this->set_page_title("Mitarbeiter Liste");
    }

    public function delete($id = "")
    {
        $kunde = Kunde::find_by_id($id);
        $kunde->delete();

        redirect('kundenverwaltung/' . $kunde->type);
    }


    public function liveSearch($search_str = '')
    {
        $kundens = Kunde::find('all', array('conditions' => array('k_num like "%' . $search_str . '%" OR name like "%' . $search_str . '%"
            AND (type = "agenturen" OR type = "stammkunden")')));
        $result = array();
        foreach ($kundens as $kunde)
            $result[] = array("text" => "<b>" . $kunde->k_num . "</b> - " . $kunde->name, "value" => $kunde->k_num);
        echo json_encode($result);
        exit();
    }

}
