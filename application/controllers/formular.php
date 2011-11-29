<?php

define("BLANK_FILE", "UNI_Briefpapier.pdf");
require_once APPPATH . "libraries/MPDF/mpdf.php";


class Formular extends MY_Controller
{

    private function write_to_pdf($v_num, $type)
    {
        $pdf = new mPDF('utf-8', 'A4', '8', '', 4, 4, 25, 25, 0, 0);
        $pdf->SetImportUse();
        $pdf->AddPage();
        $pagecount = $pdf->SetSourceFile(BLANK_FILE);
        $tplId = $pdf->ImportPage($pagecount);
        $pdf->UseTemplate($tplId);

        $view = "";
        if ($type == 1)
            $view = "angebot";
        elseif ($type == 2)
            $view = "angebotK";
        elseif ($type == 3)
            $view = "rechnung";
        elseif ($type == 4)
            $view = "rechnungK";

        $this->view_data['formular'] = Formular_model::first(array("conditions" => array("v_num = ?", $v_num)));
        $this->fill_price($this->view_data['formular']);

        $html = $this->load->view("email/" . $view, $this->view_data, TRUE);


        $stylesheet = file_get_contents('css/pdf.css');
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->list_indent_first_level = 0;
        $pdf->WriteHTML($html, 2);

        $pdf->Output("pdf/" . $v_num . "_" . $type . '.pdf', 'F');
    }


    public function __construct()
    {
        parent::__construct();

        $this->view_data['JS_files'] = array("js/formular.js");
    }

    private function generate_id()
    {
        return rand() % 10000 + 10000;
    }

    private function get_paramlist()
    {
        $room_type = Hotel::all(array("select" => "DISTINCT room_type"));
        $room_service = Hotel::all(array("select" => "DISTINCT room_service"));
        $room_capacity = Hotel::all(array("select" => "DISTINCT room_capacity"));

        $result = array(
            'room_type' => array(),
            'room_service' => array(),
            'room_capacity' => array()
        );

        foreach ($room_type as $item)
            $result['room_type'][] = $item->room_type;
        foreach ($room_service as $item)
            $result['room_service'][] = $item->room_service;
        foreach ($room_capacity as $item)
            $result['room_capacity'][] = $item->room_capacity;

        $this->view_data['all_params'] = $result;

    }

    public function create($agency_id = 0)
    {
        $agency = Agency_model::find_by_id($agency_id);

        if (!$agency) {
            show_404();
            return false;
        }

        if ($_POST) {
            $hotels = $manuels = array();
            if (!empty($_POST['ismanuel']) && is_array($_POST['ismanuel']))
                foreach ($_POST['ismanuel'] as $ind => $is_manuel)
                {
                    if ($is_manuel)
                        $hotels[] = array(
                            "name" => $_POST['hotelname'][$ind],
                            "date_start" => $_POST['datestart'][$ind],
                            "date_end" => $_POST['dateend'][$ind],
                            "days_count" => $_POST['dayscount'][$ind],
                            "room_capacity" => $_POST['roomcapacity'][$ind],
                            "room_type" => $_POST['roomtype'][$ind],
                            "room_service" => $_POST['service'][$ind],
                            "transfer" => $_POST['transfer'][$ind],
                            "remark" => $_POST['remark'][$ind],
                            "price" => $_POST['price'][$ind],
                            "is_manuel" => "1",
                        );
                    else
                        $hotels[] = array(
                            "name" => $_POST['hotelname'][$ind],
                            "code" => $_POST['hotelcode'][$ind],
                            "date_start" => $_POST['datestart'][$ind],
                            "date_end" => $_POST['dateend'][$ind],
                            "days_count" => $_POST['dayscount'][$ind],
                            "room_capacity" => $_POST['roomcapacity'][$ind],
                            "room_type" => $_POST['roomtype'][$ind],
                            "room_service" => $_POST['service'][$ind],
                            "transfer" => $_POST['transfer'][$ind],
                            "remark" => $_POST['remark'][$ind],
                            "price" => $_POST['price'][$ind],
                            "is_manuel" => "0",
                        );
                }

            if (!empty($_POST['manueltext']) && is_array($_POST['manueltext']))
                foreach ($_POST['manueltext'] as $ind => $manuel)
                {
                    $manuels[] = array(
                        "date_start" => $_POST['manueldatestart'][$ind],
                        "date_end" => $_POST['manueldateend'][$ind],
                        "days_count" => $_POST['dayscount'][$ind],
                        "text" => $_POST['manueltext'][$ind],
                        "price" => $_POST['manuelprice'][$ind],
                    );
                }

            $v_num = $_POST['vorgangsnummer'];


            Formular_model::create(array(
                                        "v_num" => $v_num,
                                        "type" => $this->input->post('agent_kunden'),
                                        "k_num" => $agency_id,
                                        "r_num" => $this->input->post('rechnungsnummber'),
                                        "provision" => $this->input->post('provision'),
                                        "hotels" => serialize($hotels),
                                        "manuels" => serialize($manuels),
                                        "flight_plan" => $this->input->post('flightplan'),
                                        "flight_price" => $this->input->post('flightprice'),
                                        "personcount" => $this->input->post('personcount'),
                                   ));


            redirect('formular/result/' . $v_num);
        }
        else
        {
            $this->view_data['agency'] = $agency;
            $this->view_data['formular_id'] = $this->generate_id();
            $this->view_data['person_count'] = '';
            $this->view_data['hotels'] = $this->view_data['manuels'] = array();
            $this->view_data['flight_plan'] = FALSE;
            $this->view_data['flight'] = array("content" => "", "price" => "");


            $this->get_paramlist();
        }
    }

    public function edit($v_num = 0)
    {
        $formular = Formular_model::first(array("conditions" => array("v_num = ?", $v_num)));

        if (!$formular) {
            show_404();
            return false;
        }
        if ($_POST) {
            if (!empty($_POST['ismanuel']) && is_array($_POST['ismanuel']))
                foreach ($_POST['ismanuel'] as $ind => $is_manuel)
                {
                    if ($is_manuel)
                        $hotels[] = array(
                            "name" => $_POST['hotelname'][$ind],
                            "date_start" => $_POST['datestart'][$ind],
                            "date_end" => $_POST['dateend'][$ind],
                            "days_count" => $_POST['dayscount'][$ind],
                            "room_capacity" => $_POST['roomcapacity'][$ind],
                            "room_type" => $_POST['roomtype'][$ind],
                            "room_service" => $_POST['service'][$ind],
                            "transfer" => $_POST['transfer'][$ind],
                            "remark" => $_POST['remark'][$ind],
                            "price" => $_POST['price'][$ind],
                            "is_manuel" => "1",
                        );
                    else
                        $hotels[] = array(
                            "name" => $_POST['hotelname'][$ind],
                            "code" => $_POST['hotelcode'][$ind],
                            "date_start" => $_POST['datestart'][$ind],
                            "date_end" => $_POST['dateend'][$ind],
                            "days_count" => $_POST['dayscount'][$ind],
                            "room_capacity" => $_POST['roomcapacity'][$ind],
                            "room_type" => $_POST['roomtype'][$ind],
                            "room_service" => $_POST['service'][$ind],
                            "transfer" => $_POST['transfer'][$ind],
                            "remark" => $_POST['remark'][$ind],
                            "price" => $_POST['price'][$ind],
                            "is_manuel" => "0",
                        );
                }

            if (!empty($_POST['manueltext']) && is_array($_POST['manueltext']))
                foreach ($_POST['manueltext'] as $ind => $manuel)
                {
                    $manuels[] = array(
                        "date_start" => $_POST['manueldatestart'][$ind],
                        "date_end" => $_POST['manueldateend'][$ind],
                        "days_count" => $_POST['dayscount'][$ind],
                        "text" => $_POST['manueltext'][$ind],
                        "price" => $_POST['manuelprice'][$ind],
                    );
                }


            $formular->provision = $this->input->post('provision');
            $formular->hotels = serialize($hotels);
            $formular->manuels = serialize($manuels);
            $formular->flight_plan = $this->input->post('flightplan');
            $formular->flight_price = $this->input->post('flightprice');
            $formular->personcount = $this->input->post('personcount');

            $formular->save();

            redirect('formular/result/' . $formular->id);
        }


        $this->view_data["formular"] = $formular;
        $this->get_paramlist();


    }

    public function open()
    {
        if ($_POST) {
            redirect('formular/view/' . $_POST['vorgan']);
        }
    }

    private function fix_date($date, $end = false)
    {
        $day = substr($date, 0, 2);
        return mktime(0, 0, 0, substr($date, 2, 2), ($end ? $day - 1 : $day), substr($date, 4));
    }

    public function find($mode = "")
    {
        $this->layout_view = '';

        if (empty($mode))
            return "";

        $hotel_code = $this->input->post('hotelcode');
        $room_type = $this->input->post('roomtype');
        $room_capacity = $this->input->post('roomcapacity');
        $room_service = $this->input->post('service');
        $date_start = $this->input->post('datestart');
        $date_end = $this->input->post('dateend');

        $result = array();

        switch ($mode)
        {
            case "name":
                $sql_options = array('conditions' => array('code = ?', $hotel_code),
                                     'select' => 'name, stars');
                $hotel = Hotel::first($sql_options);

                if (!$hotel)
                    echo "NO FOUND";
                else
                    echo $hotel->name . " " . $hotel->stars . " *";

                return TRUE;

            case "room_type":
                $sql_options = array('conditions' => array('code = ?', $hotel_code),
                                     'select' => 'DISTINCT room_type');
                $hotels = Hotel::all($sql_options);

                foreach ($hotels as $hotel)
                    $result[] = array("value" => $hotel->room_type, "name" => $hotel->room_type);

                echo json_encode($result);
                break;

            case "room_capacity":
                $sql_options = array('conditions' => array('code = ? AND room_type = ?', $hotel_code, $room_type),
                                     'select' => 'DISTINCT room_capacity');
                $hotels = Hotel::all($sql_options);

                foreach ($hotels as $hotel)
                    $result[] = array("value" => $hotel->room_capacity, "name" => $hotel->room_capacity);

                echo json_encode($result);
                break;

            case "room_service":
                $sql_options = array('conditions' => array('code = ? AND room_type = ? AND room_capacity = ?', $hotel_code, $room_type, $room_capacity),
                                     'select' => 'DISTINCT room_service');
                $hotels = Hotel::all($sql_options);

                foreach ($hotels as $hotel)
                    $result[] = array("value" => $hotel->room_service, "name" => $hotel->room_service);

                echo json_encode($result);
                break;

            case "price":
                $price = 0;
                $date_start = $this->fix_date($date_start);
                $date_end = $this->fix_date($date_end, TRUE);

                while ($date_start <= $date_end)
                {
                    $sql_options = array('conditions' => array('code = ? AND room_type = ? AND room_capacity = ? AND room_service = ? AND date = ?',
                                                               $hotel_code, $room_type, $room_capacity, $room_service, $date_start),
                                         'select' => 'price');

                    $price_found = Hotel::first($sql_options);
                    if (!$price_found) {
                        $price = 0;
                        break;
                    }
                    $price += $price_found->price;

                    $day = getdate($date_start);
                    $date_start = mktime(0, 0, 0, $day['mon'], $day['mday'] + 1, $day['year']);
                }

                echo $price;

                break;
        }
    }

    private function fill_price($formular)
    {
        $hotel_price = $manuel_price = 0;
        $hotels = unserialize($formular->hotels);
        foreach ($hotels as $hotel)
            $hotel_price += $hotel['price'];

        $manuels = unserialize($formular->manuels);
        foreach ($manuels as $manuel)
            $manuel_price += $manuel['price'];

        $price = $hotel_price;
        $price += $formular->flight_price;
        $price = $price * $formular->personcount;

        $price_data = array();

        $price_data['brutto'] = $price + $manuel_price;
        $price_data['person'] = $formular->personcount == 0 ? 0 : $price_data['brutto'] / $formular->personcount;
        $price_data['netto'] = round($price_data['brutto'] / 1.19, 2);
        $price_data['provision'] = round($price_data['brutto'] * $formular->provision / 100, 2);
        $price_data['percent'] = round($price_data['provision'] / 1.19 * 0.19, 2);
        $price_data['anzahlung'] = $formular->anzahlung;
        $price_data['anzahlung_value'] = round($price_data['brutto'] / 100 * $formular->anzahlung);

        $this->view_data['price'] = $price_data;
    }


    public function result($id = 0)
    {
        $formular = Formular_model::first(array('conditions' => array('v_num = ?', $id)));

        if (!$formular) {
            show_404();
            return false;
        }

        $this->view_data['JS_files'][] = "js/result.js";

        $this->view_data['formular'] = $formular;

        if ($_POST) {

            foreach ($_POST['person_name'] as $ind => $person)
            {
                $persons[] = array(
                    "name" => $_POST['person_name'][$ind],
                    "sex" => $_POST['sex'][$ind],
                );
            }

            $formular->persons = serialize($persons);
            $formular->comment = $this->input->post("bigcomment");
            $formular->anzahlung = $this->input->post("anzahlung");
            $formular->abreisedatum = $this->input->post("abreisedatum");
            $formular->address = $this->input->post("address");
            $formular->zahlungsdatum = $this->input->post("zahlungsdatum");

            $formular->save();

            $this->write_to_pdf($id, 1);
            $this->write_to_pdf($id, 2);
            $this->write_to_pdf($id, 3);
            $this->write_to_pdf($id, 4);

            redirect('formular/final/' . $formular->v_num);
        }
        else
        {
            $this->fill_price($formular);
        }
    }

    public function final_($id)
    {
        $formular = Formular_model::first(array('conditions' => array('v_num = ?', $id)));

        if (!$formular) {
            show_404();
            return false;
        }

        $this->view_data['JS_files'][] = "js/final.js";

        $this->view_data['formular'] = $formular;



        $this->fill_price($formular);


        if ($formular->stage == 2)
            $this->set_right_header('Rechnungnummer: ' . $formular->r_num);
  
        $this->set_left_header(($formular->stage == 1 ? "Angebot" : "Rechnung") . " Formular: " .
                               ($formular->agency->type == 'person'
                                       ? $formular->agency->name . " " . $formular->agency->surname
                                       : $formular->agency->name));
        $this->content_view = "formular/final";
    }


    public function do_rechnung($id = 0)
    {
        $formular = Formular_model::first(array('conditions' => array("v_num = ? ", $id)));

        if (!$formular) {
            show_404();
            return false;
        }

        if ($formular->stage == 2)
            return true;

        $formular->stage = 2;
        $formular->save();

        redirect("formular/final/" . $formular->v_num);
    }


}
