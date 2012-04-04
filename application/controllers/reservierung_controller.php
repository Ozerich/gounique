<?php

define("BLANK_FILE", "blank.pdf");
require_once APPPATH . "libraries/MPDF/mpdf.php";

class Reservierung_Controller extends MY_Controller
{

    public function send_report()
    {

        $item_type = $this->input->post('type');
        $item_id = $this->input->post('id');

        $item = $item_type == "hotel" ? FormularHotel::find_by_id($item_id) : FormularManuel::find_by_id($item_id);
        if (!$item)
            exit();

        $formular = Formular::find_by_id($item->formular_id);

        $incoming = $item->incoming;

        if (!$incoming || !$incoming->email)
            exit();

        $email = $incoming->email;
        $hotel_text = $item->incoming_report;
        $flight = $formular->flight_text;

        $item->incoming_sendtime = time_to_mysqldatetime(time());
        $item->save();

        $text =
            "Dear all,

please book and confirm by return:

        " . $hotel_text . "

Flightdetails:

" . $flight . "

Thank you
Best regards
Your Unique World Team";

        $text = str_replace("\n", "\t\r\n", $text);

        $this->email->clear();
        $this->email->from($this->user->email, $this->user->name . " " . $this->user->surname . " <" . $this->user->email . ">");
        $this->email->to($email);
        $this->email->subject("Unique World Report");
        $this->email->message($text);
        $this->email->send();

        exit();
    }

    public function create_voucher()
    {
        $persons = explode(',', $this->input->post('persons'));
        if (!$persons)
            exit();

        $url = $this->do_voucher($this->input->post('item_id'), $this->input->post('item_type'), $persons, $this->input->post('incoming_id'));

        echo $url;
        exit();
    }

    private function do_voucher($item_id, $item_type, $persons, $incoming_id)
    {
        $item = $item_type == "hotel" ? FormularHotel::find_by_id($item_id) : FormularManuel::find_by_id($item_id);
        $formular = Formular::find_by_id($item->formular_id);

        if (!$formular)
            return;

        $this->view_data['formular'] = $formular;
        $this->view_data['item'] = $item;
        $this->view_data['incoming'] = Incoming::find_by_id($incoming_id);
        $this->view_data['persons'] = array();
        foreach ($persons as $person_id)
            $this->view_data['persons'][] = FormularPerson::find_by_id($person_id);

        $pdf = new mPDF('utf-8', 'A4', '8', '', 0, 0, 0, 0, 0, 0);
        $pdf->SetImportUse();
        $pdf->AddPage();
        $pagecount = $pdf->SetSourceFile("voucher_blank.pdf");
        $tplId = $pdf->ImportPage($pagecount);
        $pdf->UseTemplate($tplId);

        $view = ($item->type == "hotel") ? "hotel" : "manuel";

        $html = $this->load->view("vouchers/" . $view, $this->view_data, TRUE);

        $stylesheet = file_get_contents('css/voucher.css');
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->list_indent_first_level = 0;
        $pdf->WriteHTML($html, 2);

        $pdf->Output("pdf/" . $item->voucher_name, 'F');
        return "pdf/" . $item->voucher_name;

    }

    public function print_file($formular_id, $type)
    {
        $formular = Formular::find_by_id($formular_id);

        if (!$formular)
            return;

        $this->view_data['formular'] = $formular;

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
        elseif ($type == 5)
            $view = "storeno";
        elseif ($type == 6)
            $view = "storenoK";
        elseif ($type == 7)
            $view = "gutschrift";

        $html = $this->load->view("pdf_reports/" . $view, $this->view_data, TRUE);

        $stylesheet = file_get_contents('css/pdf.css');
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->list_indent_first_level = 0;
        $pdf->WriteHTML($html, 2);

        $path = 'pdf/' . $formular->id . "_" . $type . ".pdf";
        $pdf->Output($path, 'F');
        echo $path;
        exit();
    }


    public function get_pdf_name($formular_id)
    {
        $formular = Formular::find_by_id($formular_id);
        if (!$formular)
            return "NONAME";

        switch ($formular->status) {
            case "angebot":
                return "Angebot-" . ($formular->persons ? $formular->persons[0]->name : '') . "-UniqueWorld";
            case "rechnung":
                return ($formular->is_storno ? 'Stornorechnung-' : "Rechnung-") . str_replace('/', '', $formular->r_num) . "-UniqueWorld";
            case 'eingangsmitteilung':
                return "Eingangsmitteilung-" . ($formular->persons ? $formular->persons[0]->name : '') . "-UniqueWorld";
            case "storno":
                return "Rechnung-" . str_replace('/', '', $formular->r_num) . "-UniqueWorld";
            case 'gutschrift':
                return "Gutschrift-" . str_replace('/', '', $formular->r_num) . "-UniqueWorld";
        }
    }


    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('');

        $this->view_data['JS_files'] = array("js/reservierung.js");

        $this->load->helper('date');
        $this->load->library("email");
    }

    public function generate_vnum($type = "")
    {
        $val = "";

        if ($type == "bausteinreise") {
            $next_bnum = Config::find_by_param('next_bausteinreise_vnum');
            $val = "B" . $next_bnum->value++;
            $next_bnum->save();
        }

        echo $val;
        exit();
    }

    private function get_prepayment_date()
    {
        $today = getdate(time());
        return mktime(0, 0, 0, $today['mon'], $today['mday'] + 2, $today['year']);
    }

    public function index()
    {
        if ($_POST) {
            $kunde_id = $this->input->post('kunde_id');
            $kunde = Kunde::find_by_k_num($kunde_id);

            if (!$kunde) {
                $this->view_data['error'] = 'Client mit der Nummer "' . $kunde_id . '" wurde nicht gefunden';
            }
            else
            {
                redirect("reservierung/create/" . $kunde->id);
            }
        }
    }

    public function change_agency($formular_id = 0, $agency_id = 0)
    {
        $formular = Formular::find_by_id($formular_id);
        $agency = Kunde::find_by_id($agency_id);

        if (!$formular || !$agency) {
            show_404();
            return false;
        }

        $formular->kunde_id = $agency_id;
        $formular->provision = $agency->provision;
        $formular->provision_amount = round($formular->brutto * $formular->provision * (!$formular->kunde->ausland ? 1.19 : 1) / 100, 2);
        $formular->save();

        exit();
    }


    public function change_vnum($formular_id = 0)
    {
        $formular = Formular::find_by_id($formular_id);

        if (!$formular) {
            show_404();
            return false;
        }

        if (strlen($this->input->post('value')) < 5)
            exit();

        $formular->v_num = strtoupper($this->input->post('value'));
        $formular->save();

        exit();
    }

    public function change_ownertype($formular_id = 0)
    {
        $formular = Formular::find_by_id($formular_id);

        if (!$formular) {
            show_404();
            return false;
        }

        $formular->owner_type = $this->input->post('value');
        $formular->save();

        exit();
    }

    public function create($kunde_id = '')
    {
        $kunde = null;

        if ($kunde_id) {
            $kunde = Kunde::find_by_id($kunde_id);

            if (!$kunde) {
                show_404();
                return false;
            }
        }

        if ($_POST) {
            $type = $this->input->post('formular-type');

            $flight = $v_num = $flight_price = $service_charge = $person_count = '';
            switch ($type) {

                case 'pausschalreise':

                    $flight = $this->input->post('p_flight');
                    $flight_price = $this->input->post('p_flightprice');
                    $v_num = $this->input->post('p_vnum');
                    $service_charge = $person_count = 0;

                    if (!$flight || !is_numeric($flight_price) || strlen($v_num) != 6)
                        return false;

                    break;

                case 'bausteinreise':

                    $flight = $this->input->post('b_flight');
                    $flight_price = $this->input->post('b_flightprice');
                    $v_num = $this->input->post('b_vnum');
                    $service_charge = $person_count = 0;

                    if (!strlen($v_num) == 6)
                        return false;

                    break;

                case 'nurflug':

                    $v_num = $this->input->post('n_vnum');
                    $flight = $this->input->post('n_flight');
                    $flight_price = $this->input->post('n_flightprice');
                    $person_count = $this->input->post('n_personcount');
                    $service_charge = $this->input->post('n_servicecharge');
                    if (strlen($v_num) != 6 || !$flight || !is_numeric($flight_price) || !is_numeric($person_count) || !is_numeric($service_charge))
                        return false;

                    break;
            }

            $formular = Formular::create(array(
                'v_num' => strtoupper($v_num),
                'kunde_id' => $kunde_id,
                'type' => $type,
                'provision' => $kunde ? $kunde->provision : 0,
                'service_charge' => $service_charge,
                'flight_text' => $flight,
                'flight_price' => $flight_price,
                'person_count' => $person_count,
                'owner_type' => $this->input->post('owner_type'),
                'created_date' => time_to_mysqldatetime(time()),
                'changed_date' => time_to_mysqldatetime(time()),
                'created_by' => $this->user->id,
                'changed_by' => $this->user->id,
            ));

            $formular->brutto = $formular->brutto_price;
            $formular->save();

            $formular->create_flight_segments();

            redirect('reservierung/' . ($type == 'nurflug' ? 'final' : 'edit') . '/' . $formular->id);
        }
        else
            $this->view_data['kunde'] = $kunde;
    }

    public function delete_item($item_id = 0, $item_type = 'hotel')
    {
        $item = $item_type == 'hotel' ? FormularHotel::find_by_id($item_id) : FormularManuel::find_by_id($item_id);
        if (!$item) {
            show_404();
            exit();
        }

        $item->delete();

        $formular = Formular::find_by_id($item->formular_id);

        echo $this->load->view('reservierung/item_list.php', array('items' => $formular->hotels_and_manuels), true);
        exit();
    }

    public function update_item($formular_id = 0, $item_id = 0, $item_type = 'manuel')
    {
        $formular = Formular::find_by_id($formular_id);

        if ($_POST) {
            $item_type = $this->input->post('item-type');
            $item_id = $this->input->post('item-id');

            $item = $item_type == 'hotel' ? FormularHotel::find_by_id($item_id) : FormularManuel::find_by_id($item_id);
            if (!$formular || ($item && $item->formular_id != $formular_id)) {
                show_404();
                return false;
            }

            if ($item_type == 'manuel') {
                $manuel = $item ? $item : FormularManuel::create(array('text' => ''));

                $manuel->text = $this->input->post('text');
                if ($this->input->post('date_enabled')) {
                    $manuel->date_start = inputdate_to_mysqldate($this->input->post('date_start'));
                    $manuel->date_end = inputdate_to_mysqldate($this->input->post('date_end'));
                    $manuel->days_count = $this->input->post('days_count');
                }
                else
                {
                    $manuel->date_start = $manuel->date_end = null;
                    $manuel->days_count = 0;
                }
                $manuel->price = $this->input->post('price');
                $manuel->voucher_remark = $this->input->post('voucher_remark');
                $manuel->incoming_id = $this->input->post('incoming');
                $manuel->formular_id = $formular_id;
                $manuel->count = $this->input->post('count');

                $manuel->save();
            }
            else if ($item_type == 'hotel') {
                $hotel = $item ? $item : FormularHotel::create(array());

                $hotel->roomcapacity = $this->input->post('roomcapacity');
                $hotel->roomtype = $this->input->post('roomtype');
                $hotel->hotelservice_id = $this->input->post('service');
                $hotel->date_start = inputdate_to_mysqldate($this->input->post('date_start'));
                $hotel->date_end = inputdate_to_mysqldate($this->input->post('date_end'));
                $hotel->days_count = $this->input->post('days_count');
                $hotel->price = $this->input->post('price');
                $hotel->transfer = $this->input->post('transfer');
                $hotel->transfer_price = $this->input->post('transfer_price');
                $hotel->remark = $this->input->post('remark');
                $hotel->hotel_name = $this->input->post('hotelname');
                $hotel->voucher_remark = $this->input->post('voucher_remark');
                $hotel->city_tour = $this->input->post('city_tour');
                $hotel->incoming_id = $this->input->post('incoming');
                $hotel->formular_id = $formular_id;
                $hotel->count = $this->input->post('count');

                $hotel->save();
            }

            $arrival_date = $formular->count_arrival_date();

            if ($arrival_date)
                $formular->arrival_date = $arrival_date;

            $formular->brutto = $formular->brutto_price;
            $formular->provision_amount = round($formular->brutto * $formular->provision * (!$formular->kunde->ausland ? 1.19 : 1) / 100, 2);
            if ($formular->status == "rechnung") {
                $formular->prepayment_amount = $formular->brutto * $formular->prepayment / 100;
                $formular->finalpayment_amount = $formular->brutto - $formular->prepayment_amount;
            }
            $formular->save();


            echo $this->load->view('reservierung/item_list.php', array('items' => $formular->hotels_and_manuels), true);
            exit();
        }

        $item = $item_type == 'hotel' ? FormularHotel::find_by_id($item_id) : FormularManuel::find_by_id($item_id);
        if (!$formular || ($item && $item->formular_id != $formular_id)) {
            show_404();
            return false;
        }

        echo $this->load->view('reservierung/edit_item.php', array('item' => $item), true);
        exit();
    }

    public function edit($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }
        if ($_POST) {

            $type = $formular->type;

            $provision = 0;
            if ($type != 'nurflug')
                $provision = $this->input->post('provision-manuel') != '' ? str_replace(',', '.', $this->input->post('provision-manuel')) :
                    $formular->kunde->provision;

            $formular->provision = $provision;
            $formular->service_charge = $type == 'nurflug' ? $this->input->post('nurflug_servicecharge') : 0;
            $formular->flight_text = strtoupper($type == 'nurflug' ? $this->input->post('nurflug_flight') : $this->input->post('flight'));
            $formular->flight_price = $type == 'nurflug' ? $this->input->post('nurflug_flightprice') : $this->input->post('flightprice');
            $formular->person_count = $type == 'nurflug' ? $this->input->post('nurflug_personcount') : $this->input->post('personcount');

            $formular->changed_by = $this->user->id;
            $formular->changed_date = time_to_mysqldatetime(time());

            $arrival_date = $formular->count_arrival_date();
            $departure_date = $formular->count_departure_date();

            if ($arrival_date && !$formular->arrival_date)
                $formular->arrival_date = $arrival_date;

            if ($departure_date && !$formular->departure_date)
                $formular->departure_date = $departure_date;

            $formular->brutto = $formular->brutto_price;

            $formular->provision_amount = round($formular->brutto * $formular->provision * (!$formular->kunde->ausland ? 1.19 : 1) / 100, 2);
            if ($formular->status == "rechnung") {
                $formular->prepayment_amount = $formular->brutto * $formular->prepayment / 100;
                $formular->finalpayment_amount = $formular->brutto - $formular->prepayment_amount;
            }

            $formular->update_freigabe();
            $formular->save();
            $formular->create_flight_segments();

            redirect('reservierung/result/' . $formular->id);
        }


        $this->view_data["formular"] = $formular;
        $this->view_data['item_list'] = $this->load->view('reservierung/item_list.php', array('items' => $formular->hotels_and_manuels), true);

    }

    public function find($mode = "")
    {
        $this->layout_view = '';

        if (empty($mode))
            return "";

        $hotel_code = $this->input->post('hotelcode');
        $room_type = $this->input->post('roomtype');
        $room_capacity = $this->input->post('roomcapacity');
        $hotel_service = $this->input->post('service');
        $date_start = $this->input->post('datestart');
        $date_end = $this->input->post('dateend');

        $result = array();

        switch ($mode)
        {
            case "vnum":
                echo Formular::find_by_v_num($this->input->post('value')) ? 1 : 0;
                break;
            case "name":
                $sql_options = array('conditions' => array('code = ?', $hotel_code),
                    'select' => 'name, stars');
                $hotel = Hotel::first($sql_options);

                if (!$hotel)
                    echo "NO FOUND";
                else
                    echo $hotel->name;

                return TRUE;

            case "room_type":
                $sql_options = array('conditions' => array('hotel_id = ?', Hotel::find_by_code($hotel_code)->id),
                    'select' => 'DISTINCT roomtype_id');
                $room_type = HotelOffer::all($sql_options);

                $result = array();
                foreach ($room_type as $type)
                {
                    $type = RoomType::find_by_id($type->roomtype_id);
                    $result[] = array("id" => $type->id, "value" => $type->value);
                }

                echo json_encode($result);
                break;

            case "room_capacity":
                $sql_options = array('conditions' => array('hotel_id = ? AND roomtype_id = ?', Hotel::find_by_code($hotel_code)->id, $room_type),
                    'select' => 'DISTINCT roomcapacity_id');

                $room_type = HotelOffer::all($sql_options);
                $result = array();
                foreach ($room_type as $type)
                {
                    $type = RoomCapacity::find_by_id($type->roomcapacity_id);
                    $result[] = array("id" => $type->id, "value" => $type->value);
                }

                echo json_encode($result);
                break;

            case "hotel_service":
                $sql_options = array('conditions' => array('hotel_id = ? AND roomtype_id = ? AND roomcapacity_id = ?',
                    Hotel::find_by_code($hotel_code)->id, $room_type, $room_capacity),
                    'select' => 'DISTINCT hotelservice_id');
                $hotel_service = HotelOffer::all($sql_options);
                $result = array();
                foreach ($hotel_service as $type)
                {
                    $type = HotelService::find_by_id($type->hotelservice_id);
                    $result[] = array("id" => $type->id, "value" => $type->value);
                }

                echo json_encode($result);
                break;

            case "price":
                $price = 0;
                $date_start = mysqldate_to_timestamp(inputdate_to_mysqldate($date_start));
                $date_end = mysqldate_to_timestamp(inputdate_to_mysqldate($date_end, TRUE));

                while ($date_start <= $date_end)
                {

                    $sql_options = array('conditions' => array('hotel_id = ? AND roomtype_id = ? AND roomcapacity_id = ? AND hotelservice_id = ?
                        AND date = ?', Hotel::find_by_code($hotel_code)->id, $room_type, $room_capacity, $hotel_service, time_to_mysqldate($date_start)),
                        'select' => 'price');

                    $price_found = HotelOffer::first($sql_options);

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


    public function result($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        $this->view_data['formular'] = $formular;

        if ($_POST) {

            if (isset($_POST['person_sex']) && is_array($_POST['person_sex']))
                foreach ($_POST['person_sex'] as $ind => $person_sex)
                {
                    if (isset($_POST['person_id'][$ind])) {
                        $person = FormularPerson::find_by_id($_POST['person_id'][$ind]);
                        $person->sex = $_POST['person_sex'][$ind];
                        $person->name = strtoupper($_POST['person_name'][$ind]);
                        $person->surname = strtoupper($_POST['person_surname'][$ind]);

                        $person->save();
                    }
                    else
                        FormularPerson::create(array(
                            "formular_id" => $formular->id,
                            "name" => strtoupper($_POST['person_name'][$ind]),
                            "surname" => strtoupper($_POST['person_surname'][$ind]),
                            "sex" => $_POST['person_sex'][$ind]
                        ));
                }

            $formular->comment = $this->input->post("bigcomment");
            $formular->departure_date = inputdate_to_mysqldate($this->input->post('departure_date'));
            $formular->arrival_date = inputdate_to_mysqldate($this->input->post('arrival_date'));
            $formular->save();

            redirect('reservierung/final/' . $formular->id);
        }

    }

    public function status($id)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        if ($_POST) {
            $item = ($this->input->post('item_type') == 'hotel') ? FormularHotel::find_by_id($this->input->post('item_id'))
                : FormularManuel::find_by_id($this->input->post('item_id'));

            FormularStatusLog::create(array(
                'item_type' => $this->input->post('item_type'),
                'item_id' => $this->input->post('item_id'),
                'old_status' => $item->status,
                'new_status' => $this->input->post('status'),
                'comment' => $this->input->post('comment'),
                'user_id' => $this->user->id,
                'datetime' => time_to_mysqldatetime(time()),
            ));

            $item->status = $this->input->post('status');
            $item->save();

            redirect("reservierung/status/" . $formular->id);
        }

        $this->view_data['formular'] = $formular;

    }

    public function final_($id)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        $this->view_data['formular'] = $formular;

        $this->content_view = "reservierung/final";
    }


    public function do_rechnung($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        $sofort = $this->input->post('sofort') != '';

        $formular->departure_date = inputdate_to_mysqldate($this->input->post("departure_date"));
        $formular->provision_date = $formular->departure_date->add(new DateInterval('P5D'));
        $formular->finalpayment_date = inputdate_to_mysqldate($this->input->post("finalpayment_date"));
        $formular->prepayment = $sofort ? 0 : $this->input->post("prepayment");
        $formular->prepayment_date = $sofort ? null : inputdate_to_mysqldate($this->input->post("preprepayment_date"));
        $formular->prepayment_amount = $sofort ? 0 : $formular->brutto * $formular->prepayment / 100;
        $formular->finalpayment_amount = $formular->brutto - $formular->prepayment_amount;
        $formular->rechnung_date = time_to_mysqldate(time());
        $formular->changed_date = time_to_mysqldate(time());
        $formular->changed_by = $this->user->id;

        $next_rnum = Config::find_by_param('next_rnum');
        $formular->status = "rechnung";

        $formular->r_num_int = $next_rnum->value < 10 ? "0" . $next_rnum->value : $next_rnum->value;
        $formular->r_num = "201100/" . $formular->r_num_int;

        $next_rnum->value = $next_rnum->value + 1;
        $next_rnum->save();

        $formular->save();

        redirect("reservierung/final/" . $formular->id);
    }

    public function eingangsmitteilung($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        $formular->status = "eingangsmitteilung";
        $formular->save();


        redirect("reservierung/final/" . $formular->id);
    }

    public function storeno($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        if ($_POST) {
            $formular->status = 'storno';
            $formular->is_storno = true;
            $formular->storno_date = inputdate_to_mysqldate($this->input->post('date'));
            $formular->storno_percent = $this->input->post('manuel-percent');
            $formular->storno_amount = $this->input->post('manuel-value');
            $formular->storno_who = $this->input->post('who');
            $formular->storno_by = $this->user->id;
            $formular->storno_created_date = time_to_mysqldatetime(time());
            $formular->save();


            if ($formular->storno_percent)
                $brutto = $formular->brutto / 100 * $formular->storno_percent;
            else
                $brutto = $formular->brutto - $formular->storno_amount;

            $storno_rechnung = Formular::create(array(
                'kunde_id' => $formular->kunde_id,
                'status' => 'rechnung',
                'is_storno' => true,
                'r_num' => $formular->r_num . 'S',
                'r_num_int' => $formular->r_num_int,
                'v_num' => $formular->v_num,
                'type' => $formular->type,
                'flight_text' => $formular->flight_text,
                'flight_price' => $formular->flight_price,
                'provision' => $formular->provision,
                'provision_amount' => round($brutto / 100 * $formular->provision, 2) * ($formular->kunde->ausland ? 1 : 1.19),
                'provision_date' => $formular->kunde->type == "agenturen" ? time_to_mysqldate(time()) : null,
                'service_charge' => $formular->service_charge,
                'brutto' => $brutto,
                'payment_netto' => $formular->payment_netto,
                'finalpayment_amount' => $brutto,
                'finalpayment_date' => time_to_mysqldate(time()),
                'departure_date' => $formular->departure_date,
                'arrival_date' => $formular->arrival_date,
                'rechnung_date' => time_to_mysqldatetime(time()),
                'person_count' => $formular->person_count,
                'comment' => $formular->comment,
                'created_date' => time_to_mysqldatetime(time()),
                'created_by' => $this->user->id,
                'changed_date' => time_to_mysqldatetime(time()),
                'changed_by' => $this->user->id,
                'storno_original' => $formular->id,
            ));

            $gutschrift = Formular::create(array(
                'kunde_id' => $formular->kunde_id,
                'status' => 'gutschrift',
                'is_storno' => true,
                'r_num' => $formular->r_num . 'G',
                'r_num_int' => $formular->r_num_int,
                'v_num' => $formular->v_num,
                'type' => $formular->type,
                'flight_text' => $formular->flight_text,
                'flight_price' => $formular->flight_price,
                'provision' => $formular->provision,
                'provision_amount' => $formular->provision_amount,
                'provision_date' => $formular->provision_date,
                'service_charge' => $formular->service_charge,
                'brutto' => -$formular->brutto,
                'finalpayment_amount' => -$formular->brutto,
                'finalpayment_date' => time_to_mysqldate(time()),
                'departure_date' => $formular->departure_date,
                'arrival_date' => $formular->arrival_date,
                'rechnung_date' => time_to_mysqldatetime(time()),
                'person_count' => $formular->person_count,
                'comment' => $formular->comment,
                'created_date' => time_to_mysqldatetime(time()),
                'created_by' => $this->user->id,
                'changed_date' => time_to_mysqldatetime(time()),
                'changed_by' => $this->user->id,
                'storno_original' => $formular->id,
            ));


            $payments = IncomingPayment::find_all_by_formular_id($formular->id);
            foreach ($payments as $payment) {

                IncomingPayment::create(array(
                    'formular_id' => $storno_rechnung->id,
                    'amount' => $payment->added_by == 0 ? $storno_rechnung->provision_amount : $payment->amount,
                    'type' => $payment->type,
                    'payment_date' => $payment->payment_date,
                    'remark' => $payment->remark,
                    'added_time' => time_to_mysqldatetime(time()),
                    'added_by' => $payment->added_by
                ));
            }

            $payments = ProvisionPayment::find_all_by_formular_id($formular->id);
            foreach ($payments as $payment)
            {
                ProvisionPayment::create(array(
                    'formular_id' => $storno_rechnung->id,
                    'amount' => $payment->added_by == 0 ? $storno_rechnung->provision_amount : $payment->amount,
                    'payment_date' => $payment->payment_date,
                    'remark' => $payment->remark,
                    'added_time' => time_to_mysqldatetime(time()),
                    'added_by' => $payment->added_by
                ));
            }

            redirect("reservierung/final/" . $storno_rechnung->id);
        }

        $this->view_data['formular'] = $formular;
    }

    public function vouchers($id = "")
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        $this->view_data['formular'] = $formular;
        $this->view_data['incoming'] = Incoming::all();

    }


    public function sendmail($id)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            echo "Incorrect formular id";
            exit();
        }

        $email = $this->input->post("email");
        $pdf = $this->input->post("type");


        $this->email->clear();
        $this->email->from($this->user->email, $this->user->name . " " . $this->user->surname . " <" . $this->user->email . ">");
        $this->email->to($email);

        $subject = '';
        if ($formular->status == 'angebot')
            $subject = 'Ihr Reiseangebot ' . $formular->v_num;
        else if ($formular->status == 'rechnung')
            $subject = 'Ihre ' . ($formular->is_storno ? 'Stornorechnung ' : 'Buchungsbestätigung/Rechnung ') . $formular->r_num;
        else if ($formular->status == 'eingangsmitteilung')
            $subject = 'Vielen Dank für Ihre Buchung ' . $formular->v_num;
        else if ($formular->status == 'gutschrift')
            $subject = 'Ihre Gutschrift ' . $formular->r_num;
        else if ($formular->status == 'storno')
            $subject = 'Ihre Buchungsbestätigung/Rechnung ' . $formular->r_num;

        $this->email->subject($subject);

        $text = '';
        if ($formular->status == "angebot")
            $text = Config::find_by_param("emailtext_angebot")->value;
        else if ($formular->status == "eingangsmitteilung")
            $text = Config::find_by_param("emailtext_eingangsmitteilung")->value;
        else if ($formular->status == "rechnung")
            $text = Config::find_by_param("emailtext_rechnung")->value;

        $filename = 'pdf/' . $this->get_pdf_name($formular->id) . ".pdf";

        $source_file = 'pdf/' . $formular->id . "_" . $pdf . ".pdf";

        @copy($source_file, $filename);

        $this->email->message($text);
        $this->email->attach($filename);

        if ($formular->status == "rechnung") {
            $this->email->attach('attachments/Reisebedingungen_UniqueWorld.pdf');
            if (!$formular->is_storno)
                $this->email->attach('attachments/Sicherungsschein_UniqueWorld.pdf');
        }

        if (!$this->email->send())
            echo "error sending";
        else
            echo "ok";

        @unlink($filename);

        exit();
    }


    public function livesearch($type = "", $str = "")
    {
        $result = array();

        switch ($type)
        {
            case "hotelcode":
                $hotels = Hotel::find('all', array('conditions' => array('code like "%' . $str . '%"')));
                foreach ($hotels as $hotel)
                    $result[] = array(
                        "text" => "<b>" . $hotel->code . "</b> - " . $hotel->name,
                        "value" => $hotel->code,
                        "data" => array("hotelname" => $hotel->name),
                    );
                break;
            case "hotelname":
                $hotels = Hotel::find('all', array('conditions' => array('name like "%' . $str . '%"')));
                foreach ($hotels as $hotel)
                    $result[] = array(
                        "text" => "<b>" . $hotel->code . "</b> - " . $hotel->name,
                        "value" => $hotel->name,
                        "data" => array("hotelcode" => $hotel->code),
                    );
                break;

            case "vnum":
                $formulars = Formular::find('all', array('conditions' => array('v_num like "%' . $str . '%"')));
                foreach ($formulars as $formular)
                    $result[] = array(
                        "text" => $formular->status . ": <b>" . $formular->v_num . "</b>",
                        "value" => $formular->v_num
                    );
                break;

            case "rnum":
                $formulars = Formular::find('all', array('conditions' => array('r_num like "%' . $str . '%"')));
                foreach ($formulars as $formular)
                    $result[] = array(
                        "text" => $formular->status . ": <b>" . $formular->r_num . "</b> (" . $formular->v_num . ")",
                        "value" => $formular->r_num
                    );
                break;

            case "kundename":
                $persons = FormularPerson::find('all', array(
                    'conditions' => array('name like "%' . $str . '%" OR surname like "%' . $str . '%"')));

                foreach ($persons as $person)
                {
                    $formular = Formular::find_by_id($person->formular_id);
                    $result[] = array(
                        "text" => $formular->status . ": " . $formular->v_num . " <b>" . $person->name . " " . $person->surname . "</b>",
                        "value" => $person->name . " " . $person->surname,
                        "data" => array("formular_id" => $formular->id),
                    );
                }
                break;
        }

        echo json_encode($result);
        exit();
    }

    public
    function open()
    {
        if ($_POST) {
            if (isset($_POST['view-vnum']))
                $formular = Formular::find_by_v_num($_POST['v_num']);
            elseif (isset($_POST['view-rnum']))
                $formular = Formular::find_by_r_num($_POST['r_num']);
            elseif (isset($_POST['view-kundename']))
            {
                $formular_id = $this->input->post("formular_id");
                if ($formular_id)
                    $formular = Formular::find_by_id($_POST['formular_id']);
            }

            redirect("reservierung/final/" . $formular->id);
        }
    }
}
