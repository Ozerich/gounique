<?php

class Kundenverwaltung_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');

        $this->view_data['JS_files'] = array("js/agency.js");
    }

    public function index()
    {
        $this->set_page_title("Kundenverwaltung");
    }

    private function add_zero($kunde_num)
    {
        if ($kunde_num < 10)
            return "000" . $kunde_num;
        else if ($kunde_num < 100)
            return "00" . $kunde_num;
        else if ($kunde_num < 1000)
            return "0" . $kunde_num;
        return $kunde_num;
    }

    private function get_first_letter($type)
    {
        switch ($type)
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

        $kunde_num = $kunde ? $this->add_zero(substr($kunde->k_num, 1) + 1) : $this->get_first_letter($type) . "0001";

        return $kunde ? substr($kunde->k_num, 0, 1) . $kunde_num : $kunde_num;
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

    public function new_($type = "")
    {
        if ($_POST) {
            switch ($type) {

                case 'ketten':

                    if (!$this->input->post('name'))
                        return false;

                    Kette::create(array(
                        'name' => $this->input->post('name'),
                        'kontakt_sex' => $this->input->post('sex'),
                        'kontakt_name' => $this->input->post('vorname'),
                        'kontakt_surname' => $this->input->post('nachname'),
                        'kontakt_strasse' => $this->input->post('strasse'),
                        'kontakt_plz' => $this->input->post('plz'),
                        'kontakt_ort' => $this->input->post('ort'),
                        'kontakt_land' => $this->input->post('land'),
                        'kontakt_phone' => $this->input->post('phone'),
                        'kontakt_fax' => $this->input->post('fax'),
                        'kontakt_email' => $this->input->post('email'),
                        'kontakt_homepage' => $this->input->post('homepage'),
                        'created_date' => time_to_mysqldatetime(time()),
                        'created_by' => $this->user->id,
                        'changed_date' => time_to_mysqldatetime(time()),
                        'changed_by' => $this->user->id
                    ));
                    break;

                case 'provisionierung':
                    ProvisionLevel::create(array(
                        'from' => $this->input->post('from'),
                        'to' => $this->input->post('to'),
                        'percent' => $this->input->post('percent'),
                    ));
                    echo $this->load->view('kundenverwaltung/provisionierung_list.php',
                        array('levels' => ProvisionLevel::all()), true);
                    exit();

                case 'incoming':
                    Incoming::create(array(
                        'name' => $this->input->post('name'),
                        'kontakt_sex' => $this->input->post('sex'),
                        'kontakt_name' => $this->input->post('vorname'),
                        'kontakt_surname' => $this->input->post('nachname'),
                        'kontakt_strasse' => $this->input->post('strasse'),
                        'kontakt_plz' => $this->input->post('plz'),
                        'kontakt_ort' => $this->input->post('ort'),
                        'kontakt_land' => $this->input->post('land'),
                        'kontakt_phone' => $this->input->post('phone'),
                        'kontakt_mobile' => $this->input->post('mobile'),
                        'kontakt_fax' => $this->input->post('fax'),
                        'kontakt_email' => $this->input->post('email'),
                        'kontakt_email2' => $this->input->post('email2'),
                        'kontakt_homepage' => $this->input->post('homepage'),
                        'bank_name' => $this->input->post('bank_name'),
                        'bank_sitz' => $this->input->post('bank_sitz'),
                        'bank_blz' => $this->input->post('bank_blz'),
                        'bank_konto' => $this->input->post('bank_konto'),
                        'bank_swift' => $this->input->post('bank_swift'),
                        'bank_iban' => $this->input->post('bank_iban'),
                        'created_date' => time_to_mysqldatetime(time()),
                        'created_by' => $this->user->id,
                        'changed_date' => time_to_mysqldatetime(time()),
                        'changed_by' => $this->user->id
                    ));
                    break;

                case 'stammkunden':
                    $name = $this->input->post('name');
                    $surname = $this->input->post('surname');

                    if (!$name || !$surname)
                        return false;

                    Kunde::create(array(
                        'k_num' => $this->get_knum('stammkunden'),
                        'type' => 'stammkunden',
                        'name' => $name . " " . $surname,
                        'strasse' => $this->input->post('strasse'),
                        'plz' => $this->input->post('plz'),
                        'ort' => $this->input->post('ort'),
                        'sex' => $this->input->post('sex'),
                        'person_name' => $name,
                        'person_surname' => $surname,
                        'email' => $this->input->post('email'),
                        'phone' => $this->input->post('phone'),
                        'mobile' => $this->input->post('mobile'),
                        'fax' => $this->input->post('fax'),
                        'land' => $this->input->post('land'),
                        'created_by' => $this->user->id,
                        'created_date' => time_to_mysqldatetime(time()),
                        'changed_by' => $this->user->id,
                        'changed_date' => time_to_mysqldatetime(time())
                    ));
                    break;

                case 'agenturen':

                    if (!$this->input->post('name'))
                        return false;

                    Kunde::create(array(
                        'k_num' => $this->get_knum('agenturen'),
                        'type' => 'agenturen',
                        'name' => $this->input->post('name'),
                        'land' => $this->input->post('land'),
                        'plz' => $this->input->post('plz'),
                        'website' => $this->input->post('website'),
                        'ort' => $this->input->post('ort'),
                        'strasse' => $this->input->post('strasse'),
                        'sex' => $this->input->post('sex'),
                        'person_name' => $this->input->post('vorname'),
                        'person_surname' => $this->input->post('nachname'),
                        'email' => $this->input->post('email'),
                        'email2' => $this->input->post('email2'),
                        'phone' => $this->input->post('phone'),
                        'mobile' => $this->input->post('mobile'),
                        'fax' => $this->input->post('fax'),
                        'ausland' => $this->input->post('ausland') ? 1 : 0,
                        'kette_id' => $this->input->post('kette'),
                        'provision_level' => $this->input->post('provision_level'),
                        'agenturtyp' => $this->input->post('agenturtyp'),
                        'zahlungsart' => $this->input->post('zahlungsart'),
                        'inkasso' => $this->input->post('inkasso'),
                        'place' => $this->input->post('place'),
                        'status' => $this->input->post('status'),
                        'bank_name' => $this->input->post('bank_name'),
                        'bank_sitz' => $this->input->post('bank_sitz'),
                        'bank_blz' => $this->input->post('bank_blz'),
                        'bank_konto' => $this->input->post('bank_konto'),
                        'bank_swift' => $this->input->post('bank_swift'),
                        'bank_iban' => $this->input->post('bank_iban'),
                        'created_by' => $this->user->id,
                        'created_date' => time_to_mysqldatetime(time()),
                        'changed_by' => $this->user->id,
                        'changed_date' => time_to_mysqldatetime(time())
                    ));

                    break;
            }

            redirect('/' . $type);
        }

        $this->content_view = "kundenverwaltung/new/" . $type;
    }

    public function agenturen($agenturen_id = 0)
    {
        $agency = Kunde::find(array('conditions' => array('id=? AND type="agenturen"', $agenturen_id)));

        if (!$agency) {
            $this->view_data['agenturen_list'] = $this->load->view('kundenverwaltung/agenturen_list.php',
                array('agencies' => Kunde::find_all_by_type('agenturen')), true);

            $this->set_page_title("Agenturen Liste");
        }
        else {
            if ($_POST) {

                if (!$this->input->post('name'))
                    return false;

                $agency->name = $this->input->post('name');
                $agency->land = $this->input->post('land');
                $agency->plz = $this->input->post('plz');
                $agency->website = $this->input->post('website');
                $agency->ort = $this->input->post('ort');
                $agency->strasse = $this->input->post('strasse');
                $agency->sex = $this->input->post('sex');
                $agency->person_name = $this->input->post('vorname');
                $agency->person_surname = $this->input->post('nachname');
                $agency->email = $this->input->post('email');
                $agency->email2 = $this->input->post('email2');
                $agency->phone = $this->input->post('phone');
                $agency->mobile = $this->input->post('mobile');
                $agency->fax = $this->input->post('fax');
                $agency->ausland = $this->input->post('ausland') ? 1 : 0;
                $agency->kette_id = $this->input->post('kette');
                $agency->provision_level = $this->input->post('provision_level');
                $agency->agenturtyp = $this->input->post('agenturtyp');
                $agency->zahlungsart = $this->input->post('zahlungsart');
                $agency->inkasso = $this->input->post('inkasso');
                $agency->place = $this->input->post('place');
                $agency->active = $this->input->post('status');
                $agency->bank_name = $this->input->post('bank_name');
                $agency->bank_sitz = $this->input->post('bank_sitz');
                $agency->bank_blz = $this->input->post('bank_blz');
                $agency->bank_konto = $this->input->post('bank_konto');
                $agency->bank_swift = $this->input->post('bank_swift');
                $agency->bank_iban = $this->input->post('bank_iban');
                $agency->save();

                redirect('agenturen');
            }
            $this->view_data['agency'] = $agency;
            $this->content_view = 'kundenverwaltung/edit/agenturen';
        }
    }

    public function stammkunden($stammkunden_id = 0)
    {
        $stammkunden = Kunde::find(array('conditions' => array('id=? AND type="stammkunden"', $stammkunden_id)));

        if (!$stammkunden) {
            $this->view_data['stammkunden_list'] = $this->load->view('kundenverwaltung/stammkunden_list.php',
                array('stammkunden' => Kunde::find_all_by_type('stammkunden')), true);

            $this->set_page_title("Stammkunden Liste");
        }
        else {
            if ($_POST) {
                $name = $this->input->post('name');
                $surname = $this->input->post('surname');

                if (!$name || !$surname)
                    return false;

                $stammkunden->name = $name . ' ' . $surname;
                $stammkunden->land = $this->input->post('land');
                $stammkunden->strasse = $this->input->post('strasse');
                $stammkunden->plz = $this->input->post('plz');
                $stammkunden->ort = $this->input->post('ort');
                $stammkunden->sex = $this->input->post('sex');
                $stammkunden->person_name = $name;
                $stammkunden->person_surname = $surname;
                $stammkunden->email = $this->input->post('email');
                $stammkunden->phone = $this->input->post('phone');
                $stammkunden->mobile = $this->input->post('mobile');
                $stammkunden->fax = $this->input->post('fax');
                $stammkunden->changed_by = $this->user->id;
                $stammkunden->changed_date = time_to_mysqldatetime(time());
                $stammkunden->save();

                redirect('stammkunden');
            }
            $this->view_data['stammkunden'] = $stammkunden;
            $this->content_view = 'kundenverwaltung/edit/stammkunden';
        }
    }

    public function incoming($incoming_id = 0)
    {
        $incoming = Incoming::find_by_id($incoming_id);

        if (!$incoming) {
            $this->view_data['incoming_list'] = $this->load->view('kundenverwaltung/incoming_list.php',
                array('incomings' => Incoming::all()), true);
            $this->set_page_title("Incoming Liste");
        }
        else {
            if ($_POST) {

                if (!$this->input->post('name'))
                    return false;

                $incoming->name = $this->input->post('name');
                $incoming->kontakt_sex = $this->input->post('kontakt_sex');
                $incoming->kontakt_name = $this->input->post('nachname');
                $incoming->kontakt_surname = $this->input->post('vorname');
                $incoming->kontakt_strasse = $this->input->post('strasse');
                $incoming->kontakt_plz = $this->input->post('plz');
                $incoming->kontakt_ort = $this->input->post('ort');
                $incoming->kontakt_land = $this->input->post('land');
                $incoming->kontakt_phone = $this->input->post('phone');
                $incoming->kontakt_mobile = $this->input->post('mobile');
                $incoming->kontakt_fax = $this->input->post('fax');
                $incoming->kontakt_email = $this->input->post('email');
                $incoming->kontakt_email2 = $this->input->post('email2');
                $incoming->kontakt_homepage = $this->input->post('homepage');
                $incoming->bank_name = $this->input->post('bank_name');
                $incoming->bank_sitz = $this->input->post('bank_sitz');
                $incoming->bank_blz = $this->input->post('bank_blz');
                $incoming->bank_konto = $this->input->post('bank_konto');
                $incoming->bank_swift = $this->input->post('bank_swift');
                $incoming->bank_iban = $this->input->post('bank_iban');
                $incoming->changed_date = time_to_mysqldatetime(time());
                $incoming->changed_by = $this->user->id;
                $incoming->save();

                redirect('incoming');
            }
            $this->view_data['incoming'] = $incoming;
            $this->content_view = 'kundenverwaltung/edit/incoming';
        }
    }

    public function provisionierung($level_id = 0)
    {
        if ($level_id == 0) {
            $this->view_data['provision_levels'] = $this->load->view('kundenverwaltung/provisionierung_list.php',
                array('levels' => ProvisionLevel::all()), true);
        }
        else {
            $level = ProvisionLevel::find_by_id($level_id);
            if (!$level)
                show_404();
            else
            {
                $level->from = $this->input->post('from');
                $level->to = $this->input->post('to');
                $level->percent = $this->input->post('percent');
                $level->save();
            }
        }
    }

    public function delete($type = "", $item_id = 0)
    {
        switch ($type) {

            case "ketten":
                Kette::table()->delete(array("id" => $item_id));
                break;

            case "provisionierung":
                ProvisionLevel::table()->delete(array("id" => $item_id));
                echo $this->load->view('kundenverwaltung/provisionierung_list.php',
                    array('levels' => ProvisionLevel::all()), true);
                exit();

            case 'incoming':
                Incoming::table()->delete(array("id" => $item_id));
                break;

            case 'agenturen':
                Kunde::table()->delete(array("id" => $item_id, "type" => "agenturen"));
                break;

            case 'stammkunden':
                Kunde::table()->delete(array("id" => $item_id, 'type' => 'stammkunden'));
                break;


            default:
                show_404();
                break;
        }

        redirect('/' . $type);
    }

    public function ketten($kette_id = 0)
    {
        $kette = Kette::find_by_id($kette_id);

        if (!$kette) {
            $this->view_data['kette_list'] = $this->load->view('kundenverwaltung/kette_list.php', array(
                'kettens' => Kette::all()), true);
            $this->content_view = 'kundenverwaltung/ketten';
        }
        else
        {
            if ($_POST) {

                if (!$this->input->post('name'))
                    return false;

                $kette->name = $this->input->post('name');
                $kette->kontakt_sex = $this->input->post('sex');
                $kette->kontakt_name = $this->input->post('nachname');
                $kette->kontakt_surname = $this->input->post('vorname');
                $kette->kontakt_strasse = $this->input->post('strasse');
                $kette->kontakt_plz = $this->input->post('plz');
                $kette->kontakt_ort = $this->input->post('ort');
                $kette->kontakt_land = $this->input->post('land');
                $kette->kontakt_phone = $this->input->post('phone');
                $kette->kontakt_fax = $this->input->post('fax');
                $kette->kontakt_email = $this->input->post('email');
                $kette->kontakt_homepage = $this->input->post('homepage');
                $kette->changed_date = time_to_mysqldatetime(time());
                $kette->changed_by = $this->user->id;
                $kette->save();

                redirect('ketten');
            }
            $this->view_data['kette'] = $kette;
            $this->content_view = 'kundenverwaltung/edit/ketten';
        }
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
