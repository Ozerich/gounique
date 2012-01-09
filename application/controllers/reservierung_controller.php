<?php

define("BLANK_FILE", "blank.pdf");
require_once APPPATH . "libraries/MPDF/mpdf.php";

class Reservierung_Controller extends MY_Controller
{

    private function do_voucher($item)
    {
        $formular = Formular::find_by_id($item->formular_id);

        if (!$formular)
            return;

        $this->view_data['formular'] = $formular;
        $this->view_data['item'] = $item;

        $pdf = new mPDF('utf-8', 'A4', '8', '', 0, 0, 0, 0, 0, 0);
        $pdf->SetImportUse();
        $pdf->AddPage();
        $pagecount = $pdf->SetSourceFile("voucher_blank.pdf");
        $tplId = $pdf->ImportPage($pagecount);
        $pdf->UseTemplate($tplId);

        $view = "";

        if ($item->type == "hotel")
            $view = "hotel";
        else
            $view = "manuel";

        $html = $this->load->view("vouchers/" . $view, $this->view_data, TRUE);

        $stylesheet = file_get_contents('css/voucher.css');
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->list_indent_first_level = 0;
        $pdf->WriteHTML($html, 2);

        $pdf->Output("pdf/" . $item->voucher_name, 'F');

    }

    private function write_pdf($formular_id)
    {
        $formular = Formular::find_by_id($formular_id);

        $this->write_to_pdf($formular_id, 1);
        $this->write_to_pdf($formular_id, 2);

        if ($formular->status == "rechnung" || $formular->status == "freigabe") {
            $this->write_to_pdf($formular_id, 3);
            $this->write_to_pdf($formular_id, 4);
        }
    }

    private function write_to_pdf($formular_id, $type)
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

        $html = $this->load->view("pdf_reports/" . $view, $this->view_data, TRUE);

        $stylesheet = file_get_contents('css/pdf.css');
        $pdf->WriteHTML($stylesheet, 1);
        $pdf->list_indent_first_level = 0;
        $pdf->WriteHTML($html, 2);

        $pdf->Output("pdf/" . $formular_id . "_" . $type . '.pdf', 'F');
    }


    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('');

        $this->view_data['JS_files'] = array("js/reservierung.js");

        $this->load->helper('date');
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

    public function create($kunde_id = 0)
    {
        if ($kunde_id == 0) {

            $this->set_page_tpl("no_kunde");

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
        else
        {

            $kunde = Kunde::find_by_id($kunde_id);

            if (!$kunde) {
                show_404();
                return;
            }

            if ($_POST) {

                $formular = Formular::create(array(
                        'v_num' => $this->input->post('formular-vnum'),
                        'kunde_id' => $this->input->post('kunde_id'),
                        'created_date' => date('Y-m-d', time()),
                        'type' => $this->input->post('formular-type'),
                        'r_num' => 0,
                        'provision' => $this->input->post('provision'),
                        'flight_text' => $this->input->post('flightplan'),
                        'flight_price' => $this->input->post('flightprice'),
                        'person_count' => $this->input->post('personcount'),
                        'sachbearbeiter' => $this->user->name . " " . $this->user->surname,
                        'prepayment_date' => time_to_mysqldate($this->get_prepayment_date())
                    )
                );


                if (isset($_POST['hotelname']) && is_array($_POST['hotelname']))
                    foreach ($_POST['hotelname'] as $ind => $hotel_name)
                    {
                        $is_manuel = !isset($_POST['hotelcode'][$ind]);
                        $hotel = $is_manuel ? null : Hotel::find_by_code($_POST['hotelcode'][$ind]);
                        $hotel_id = $hotel ? $hotel->id : 0;
                        FormularHotel::create(array(
                            'formular_id' => $formular->id,
                            'status' => 'none',
                            'hotel_id' => $hotel_id,
                            'hotel_name' => $hotel_name,
                            'roomcapacity_id' => $_POST['roomcapacity'][$ind],
                            'roomtype_id' => $_POST['roomtype'][$ind],
                            'hotelservice_id' => $_POST['service'][$ind],
                            'date_start' => inputdate_to_mysqldate($_POST['datestart'][$ind]),
                            'date_end' => inputdate_to_mysqldate($_POST['dateend'][$ind]),
                            'price' => $_POST['price'][$ind],
                            'days_count' => $_POST['dayscount'][$ind],
                            'transfer' => $_POST['transfer'][$ind],
                            'remark' => $_POST['remark'][$ind],
                            'voucher_remark' => $_POST['voucher_remark'][$ind],
                        ));
                    }

                if (isset($_POST['manuel_text']) && is_array($_POST['manuel_text']))
                    foreach ($this->input->post('manuel_text') as $ind => $manuel_text)
                    {
                        FormularManuel::create(array(
                            'formular_id' => $formular->id,
                            'status' => 'none',
                            'text' => $manuel_text,
                            'date_start' => isset($_POST['manuel_datestart'][$ind]) ? inputdate_to_mysqldate($_POST['manuel_datestart'][$ind]) : '',
                            'date_end' => isset($_POST['manuel_dateend'][$ind]) ? inputdate_to_mysqldate($_POST['manuel_dateend'][$ind]) : '',
                            'days_count' => isset($_POST['manuel_dayscount'][$ind]) ? $_POST['manuel_dayscount'][$ind] : 0,
                            'price' => $_POST['manuel_price'][$ind],
                            'voucher_remark' => $_POST['manuel_voucher_remark'][$ind],
                        ));
                    }

                redirect('reservierung/result/' . $formular->id);
            }
            else
            {
                $this->view_data['kunde'] = $kunde;
            }
            $this->set_page_tpl("kunde");
        }
    }

    public function edit($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }
        if ($_POST) {


            $formular->provision = $this->input->post('provision');
            $formular->flight_text = $this->input->post('flight-text');
            $formular->flight_price = $this->input->post('flight-price');
            $formular->person_count = $this->input->post('personcount');

            $formular->save();

            if (isset($_POST['hotelname']) && is_array($_POST['hotelname']))
                foreach ($_POST['hotelname'] as $ind => $hotel_name)
                {
                    $is_manuel = isset($_POST['hotelcode'][$ind]);
                    $hotel = !$is_manuel ? null : Hotel::find_by_code($_POST['hotelcode'][$ind]);
                    $hotel_id = $hotel ? $hotel->id : 0;

                    if (isset($_POST['formular_hotel_id'][$ind])) {
                        $hotel = FormularHotel::find_by_id($_POST['formular_hotel_id'][$ind]);

                        $hotel->roomcapacity_id = $_POST['roomcapacity'][$ind];
                        $hotel->roomtype_id = $_POST['roomtype'][$ind];
                        $hotel->hotelservice_id = $_POST['service'][$ind];
                        $hotel->date_start = inputdate_to_mysqldate($_POST['datestart'][$ind]);
                        $hotel->date_end = inputdate_to_mysqldate($_POST['dateend'][$ind]);
                        $hotel->days_count = $_POST['dayscount'][$ind];
                        $hotel->price = $_POST['price'][$ind];
                        $hotel->transfer = $_POST['transfer'][$ind];
                        $hotel->remark = $_POST['remark'][$ind];
                        $hotel->hotel_id = $hotel_id;
                        $hotel->hotel_name = $_POST['hotelname'][$ind];
                        $hotel->voucher_remark = $_POST['voucher_remark'][$ind];

                        $hotel->save();
                    }
                    else
                    {
                        FormularHotel::create(array(
                            'formular_id' => $formular->id,
                            'status' => 'none',
                            'hotel_id' => $hotel_id,
                            'hotel_name' => $hotel_name,
                            'roomcapacity_id' => $_POST['roomcapacity'][$ind],
                            'roomtype_id' => $_POST['roomtype'][$ind],
                            'hotelservice_id' => $_POST['service'][$ind],
                            'date_start' => inputdate_to_mysqldate($_POST['datestart'][$ind]),
                            'date_end' => inputdate_to_mysqldate($_POST['dateend'][$ind]),
                            'price' => $_POST['price'][$ind],
                            'days_count' => $_POST['dayscount'][$ind],
                            'transfer' => $_POST['transfer'][$ind],
                            'remark' => $_POST['remark'][$ind],
                            'voucher_remark' => $_POST['voucher_remark'][$ind],
                        ));
                    }
                }
            if (isset($_POST['manuel_text']) && is_array($_POST['manuel_text']))
                foreach ($this->input->post('manuel_text') as $ind => $manuel_text)
                {

                    if (isset($_POST['formular_manuel_id'][$ind])) {
                        $manuel = FormularManuel::find_by_id($_POST['formular_manuel_id'][$ind]);

                        $manuel->text = $manuel_text;
                        $manuel->date_start = isset($_POST['manuel_datestart'][$ind]) ? inputdate_to_mysqldate($_POST['manuel_datestart'][$ind]) : '';
                        $manuel->date_end = isset($_POST['manuel_dateend'][$ind]) ? inputdate_to_mysqldate($_POST['manuel_dateend'][$ind]) : '';
                        $manuel->days_count = isset($_POST['manuel_dayscount'][$ind]) ? $_POST['manuel_dayscount'][$ind] : 0;
                        $manuel->price = $_POST['manuel_price'][$ind];
                        $manuel->voucher_remark = $_POST['manuel_voucher_remark'][$ind];

                        $manuel->save();
                    }
                    else
                    {
                        FormularManuel::create(array(
                            'formular_id' => $formular->id,
                            'status' => 'none',
                            'text' => $manuel_text,
                            'date_start' => isset($_POST['manuel_datestart'][$ind]) ? inputdate_to_mysqldate($_POST['manuel_datestart'][$ind]) : '',
                            'date_end' => isset($_POST['manuel_dateend'][$ind]) ? inputdate_to_mysqldate($_POST['manuel_dateend'][$ind]) : '',
                            'days_count' => isset($_POST['manuel_dayscount'][$ind]) ? $_POST['manuel_dayscount'][$ind] : 0,
                            'price' => $_POST['manuel_price'][$ind],
                            'voucher_remark' => $_POST['manuel_voucher_remark'][$ind]
                        ));
                    }
                }

            redirect('reservierung/result/' . $formular->id);
        }


        $this->view_data["formular"] = $formular;

    }

    public function open()
    {
        if ($_POST) {
            redirect('reservierung/view/' . $_POST['vorgan']);
        }
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
                    echo $hotel->name . " " . $hotel->stars . " *";

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
                        $person->name = $_POST['person_name'][$ind];
                        $person->surname = $_POST['person_surname'][$ind];

                        $person->save();
                    }
                    else
                        FormularPerson::create(array(
                            "formular_id" => $formular->id,
                            "name" => $_POST['person_name'][$ind],
                            "surname" => $_POST['person_surname'][$ind],
                            "sex" => $_POST['person_sex'][$ind]
                        ));
                }

            $formular->comment = $this->input->post("bigcomment");

            $formular->prepayment = $this->input->post("prepayment");

            $formular->prepayment_date = inputdate_to_mysqldate($this->input->post("preprepayment_date"));
            $formular->finalpayment_date = inputdate_to_mysqldate($this->input->post("finalpayment_date"));
            $formular->departure_date = inputdate_to_mysqldate($this->input->post("departure_date"));

            $formular->save();

            $this->write_pdf($formular->id);

            foreach ($formular->hotels_and_manuels as $hotel)
                $this->do_voucher($hotel);

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


    public function rechnung($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        $next_rnum = Config::find_by_param('next_rnum');
        $formular->status = "rechnung";

        $formular->r_num = $next_rnum->value++;
        $next_rnum->save();

        $formular->rechnung_date = time_to_mysqldate(time());

        $formular->save();

        $this->write_to_pdf($formular->id, 3);
        $this->write_to_pdf($formular->id, 4);

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
            $formular->canceled = 1;

            $this->load->library('session');
            $user_session = $this->session->all_userdata();

            FormularCancellation::create(array(
                'formular_id' => $formular->id,
                'client_percent' => $this->input->post('client_percent'),
                'provision' => $this->input->post('provision'),
                'reason' => $this->input->post('reason'),
                'user_id' => $user_session['user_id'],
                'datetime' => time_to_mysqldatetime(time()),
            ));

            $formular->save();

            redirect("reservierung/final/" . $formular->id);
        }

        $this->view_data['formular'] = $formular;
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

        $this->load->library("email");


        $this->email->clear();
        $this->email->from($this->user->email, $this->user->name . " " . $this->user->surname . " <" . $this->user->email . ">");
        $this->email->to($email);

        $this->email->subject('Subject');
        $this->email->attach('pdf/' . $formular->id . "_" . $pdf . ".pdf");
        if (!$this->email->send())
            echo "error sending";
        else
            echo "ok";
        exit();
    }


    public function payments($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        if ($_POST) {
            FormularPayment::create(array(
                "formular_id" => $id,
                "value" => $this->input->post("payment_value"),
                "datetime" => time_to_mysqldatetime(time()),
                "user_id" => $this->user->id,
            ));

            if ($formular->paid_amount >= $formular->price['brutto']) {
                $formular->status = "freigabe";

                $formular->save();
            }

            redirect("reservierung/final/" . $id);
        }

        $this->view_data['formular'] = $formular;
    }

}
