<?php

define("BLANK_FILE", "UNI_Briefpapier.pdf");
require_once APPPATH . "libraries/MPDF/mpdf.php";

class Formular_Controller extends MY_Controller
{

    private function write_to_pdf($formular_id, $type)
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

        $this->view_data['formular'] = Formular::find_by_id($formular_id);

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

        $this->view_data['JS_files'] = array("js/formular.js");

        $this->load->helper('date');
    }

    public function generate_vnum()
    {
        $val = 0;
        do {
            $val = rand() % 1000 + 1000;
        } while (Formular::find_by_v_num($val));

        echo $val;
        exit();
    }

    public function create($agency_id = 0)
    {
        $agency = Agency::find_by_id($agency_id);

        if (!$agency) {
            show_404();
            return false;
        }

        if ($_POST) {
            $formular = Formular::create(array(
                    'v_num' => $this->input->post('formular_vnum'),
                    'agency_id' => $this->input->post('agency_id'),
                    'created_date' => date('Y-m-d', time()),
                    'type' => $this->input->post('formular-type'),
                    'r_num' => '-1',
                    'provision' => $this->input->post('provision'),
                    'flight_text' => $this->input->post('flightplan'),
                    'flight_price' => $this->input->post('flightprice'),
                    'person_count' => $this->input->post('personcount')
                )
            );
            if (isset($_POST['ismanuel']) && is_array($_POST['ismanuel']))
                foreach ($_POST['ismanuel'] as $ind => $is_manuel)
                {
                    if ($is_manuel == 0) {
                        $hotel = Hotel::find_by_code($_POST['hotelcode'][$ind]);
                        FormularHotel::create(array(
                            'formular_id' => $formular->id,
                            'status' => 'none',
                            'hotel_id' => $hotel->id,
                            'hotel_name' => $hotel->name . " " . $hotel->stars . "*",
                            'roomcapacity_id' => $_POST['roomcapacity'][$ind],
                            'roomtype_id' => $_POST['roomtype'][$ind],
                            'hotelservice_id' => $_POST['service'][$ind],
                            'date_start' => $this->usertime_to_mysql($_POST['datestart'][$ind]),
                            'date_end' => $this->usertime_to_mysql($_POST['dateend'][$ind]),
                            'price' => $_POST['price'][$ind],
                            'days_count' => $_POST['dayscount'][$ind],
                            'transfer' => $_POST['transfer'][$ind],
                            'remark' => $_POST['remark'][$ind],
                        ));
                    }
                    else
                    {
                        FormularHotel::create(array(
                            'formular_id' => $formular->id,
                            'status' => 'none',
                            'hotel_id' => '0',
                            'hotel_name' => $_POST['hotelname'][$ind],
                            'roomcapacity_id' => $_POST['roomcapacity'][$ind],
                            'roomtype_id' => $_POST['roomtype'][$ind],
                            'hotelservice_id' => $_POST['service'][$ind],
                            'date_start' => $this->usertime_to_mysql($_POST['datestart'][$ind]),
                            'date_end' => $this->usertime_to_mysql($_POST['dateend'][$ind]),
                            'price' => $_POST['price'][$ind],
                            'days_count' => $_POST['dayscount'][$ind],
                            'transfer' => $_POST['transfer'][$ind],
                            'remark' => $_POST['remark'][$ind]
                        ));
                    }
                }
            if (isset($_POST['manuel_text']) && is_array($_POST['manuel_text']))
                foreach ($this->input->post('manuel_text') as $ind => $manuel_text)
                {
                    FormularManuel::create(array(
                        'formular_id' => $formular->id,
                        'status' => 'none',
                        'text' => $manuel_text,
                        'date_start' => $this->usertime_to_mysql($_POST['manuel_datestart'][$ind]),
                        'date_end' => $this->usertime_to_mysql($_POST['manuel_dateend'][$ind]),
                        'days_count' => $_POST['manuel_dayscount'][$ind],
                        'price' => $_POST['manuel_price'][$ind]
                    ));
                }

            redirect('formular/result/' . $formular->id);
        }
        else
        {
            $this->view_data['agency'] = $agency;
            $this->view_data['person_count'] = '';
            $this->view_data['hotels'] = $this->view_data['manuels'] = array();
            $this->view_data['flight_plan'] = FALSE;
            $this->view_data['flight'] = array("content" => "", "price" => "");

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
            $formular->flight_text = $this->input->post('flightplan');
            $formular->flight_price = $this->input->post('flightprice');
            $formular->person_count = $this->input->post('personcount');

            $formular->save();

            if (isset($_POST['ismanuel']) && is_array($_POST['ismanuel']))
                foreach ($_POST['ismanuel'] as $ind => $is_manuel)
                {
                    if (isset($_POST['hotel_id'][$ind])) {
                        $hotel = FormularHotel::find_by_id($_POST['hotel_id'][$ind]);

                        $hotel->roomcapacity_id = $_POST['roomcapacity'][$ind];
                        $hotel->roomtype_id = $_POST['roomtype'][$ind];
                        $hotel->hotelservice_id = $_POST['service'][$ind];
                        $hotel->date_start = $this->usertime_to_mysql($_POST['datestart'][$ind]);
                        $hotel->date_end = $this->usertime_to_mysql($_POST['dateend'][$ind]);
                        $hotel->days_count = $_POST['dayscount'][$ind];
                        $hotel->price = $_POST['price'][$ind];
                        $hotel->transfer = $_POST['transfer'][$ind];
                        $hotel->remark = $_POST['remark'][$ind];

                        if ($is_manuel == 0) {
                            $c_hotel = Hotel::find_by_code($_POST['hotelcode'][$ind]);
                            $hotel->hotel_id = $c_hotel->id;
                            $hotel->hotel_name = $c_hotel->name . " " . $c_hotel->stars . "*";
                        }
                        else
                        {
                            $hotel->hotel_id = 0;
                            $hotel->hotel_name = $_POST['hotelname'][$ind];
                        }

                        $hotel->save();
                    }
                    else
                    {
                        if ($is_manuel == 0) {
                            $hotel = Hotel::find_by_code($_POST['hotelcode'][$ind]);
                            FormularHotel::create(array(
                                'formular_id' => $formular->id,
                                'status' => 'none',
                                'hotel_id' => $hotel->id,
                                'hotel_name' => $hotel->hotel_name . " " . $hotel->stars . "*",
                                'roomcapacity_id' => $_POST['roomcapacity'][$ind],
                                'roomtype_id' => $_POST['roomtype'][$ind],
                                'hotelservice_id' => $_POST['service'][$ind],
                                'date_start' => $this->usertime_to_mysql($_POST['datestart'][$ind]),
                                'date_end' => $this->usertime_to_mysql($_POST['dateend'][$ind]),
                                'price' => $_POST['price'][$ind],
                                'days_count' => $_POST['dayscount'][$ind],
                                'transfer' => $_POST['transfer'][$ind],
                                'remark' => $_POST['remark'][$ind],
                            ));
                        }
                        else
                        {
                            FormularHotel::create(array(
                                'formular_id' => $formular->id,
                                'status' => 'none',
                                'hotel_id' => '0',
                                'hotel_name' => $_POST['hotelname'][$ind],
                                'roomcapacity_id' => $_POST['roomcapacity'][$ind],
                                'roomtype_id' => $_POST['roomtype'][$ind],
                                'hotelservice_id' => $_POST['service'][$ind],
                                'date_start' => $this->usertime_to_mysql($_POST['datestart'][$ind]),
                                'date_end' => $this->usertime_to_mysql($_POST['dateend'][$ind]),
                                'price' => $_POST['price'][$ind],
                                'days_count' => $_POST['dayscount'][$ind],
                                'transfer' => $_POST['transfer'][$ind],
                                'remark' => $_POST['remark'][$ind]
                            ));
                        }
                    }
                }

            if (isset($_POST['manuel_text']) && is_array($_POST['manuel_text']))
                foreach ($this->input->post('manuel_text') as $ind => $manuel_text)
                {
                    if (isset($_POST['manuel_id'][$ind])) {
                        $manuel = FormularManuel::find_by_id($_POST['manuel_id'][$ind]);

                        $manuel->text = $manuel_text;
                        $manuel->date_start = $this->usertime_to_mysql($_POST['manuel_datestart'][$ind]);
                        $manuel->date_end = $this->usertime_to_mysql($_POST['manuel_dateend'][$ind]);
                        $manuel->days_count = $_POST['manuel_dayscount'][$ind];
                        $manuel->price = $_POST['manuel_price'][$ind];

                        $manuel->save();
                    }
                    else
                    {
                        FormularManuel::create(array(
                            'formular_id' => $formular->id,
                            'status' => 'none',
                            'text' => $manuel_text,
                            'date_start' => $this->usertime_to_mysql($_POST['manuel_datestart'][$ind]),
                            'date_end' => $this->usertime_to_mysql($_POST['manuel_dateend'][$ind]),
                            'days_count' => $_POST['manuel_dayscount'][$ind],
                            'price' => $_POST['manuel_price'][$ind]
                        ));
                    }
                }

            redirect('formular/result/' . $formular->id);
        }


        $this->view_data["formular"] = $formular;
        $this->view_data['hotels'] = FormularHotel::find('all', array('conditions' => array('formular_id = ?', $formular->id)));
        $this->view_data['manuels'] = FormularManuel::find('all', array('conditions' => array('formular_id = ?', $formular->id)));

    }

    public function open()
    {
        if ($_POST) {
            redirect('formular/view/' . $_POST['vorgan']);
        }
    }

    private function usertime_to_mysql($date, $end = false)
    {
        $day = substr($date, 0, 2);
        $res = mktime(0, 0, 0, substr($date, 2, 2), ($end ? $day - 1 : $day), substr($date, 4));

        return date("Y-m-d", $res);
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
                $date_start = $this->usertime_to_mysql($date_start);
                $date_end = $this->usertime_to_mysql($date_end, TRUE);

                while ($date_start <= $date_end)
                {
                    $date = date("Y-m-d", $date_start);
                    $sql_options = array('conditions' => array('hotel_id = ? AND roomtype_id = ? AND roomcapacity_id = ? AND hotelservice_id = ?
                        AND date = ?', Hotel::find_by_code($hotel_code)->id, $room_type, $room_capacity, $hotel_service, $date),
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

        $this->view_data['JS_files'][] = "js/result.js";

        $this->view_data['formular'] = $formular;

        if ($_POST) {

            if (isset($_POST['person_sex']) && is_array($_POST['person_sex']))
                foreach ($_POST['person_sex'] as $ind => $person_sex)
                {
                    if (isset($_POST['person_id'][$ind])) {
                        $person = FormularPerson::find_by_id($_POST['person_id'][$ind]);
                        $person->sex = $_POST['person_sex'][$ind];
                        $person->person_name = $_POST['person_name'][$ind];

                        $person->save();
                    }
                    else
                        FormularPerson::create(array(
                            "formular_id" => $formular->id,
                            "person_name" => $_POST['person_name'][$ind],
                            "sex" => $_POST['person_sex'][$ind]
                        ));
                }

            $formular->comment = $this->input->post("bigcomment");
            $formular->prepayment = $this->input->post("prepayment");
            $formular->payment_date = $this->usertime_to_mysql($this->input->post("prepayment_date"));

            $formular->save();

            $this->write_to_pdf($id, 1);
            $this->write_to_pdf($id, 2);
            $this->write_to_pdf($id, 3);
            $this->write_to_pdf($id, 4);

            redirect('formular/final/' . $formular->id);
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

            exit();
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

        $this->view_data['JS_files'][] = "js/final.js";

        $this->view_data['formular'] = $formular;

        // if ($formular->stage == 2)
        //   $this->set_right_header('Rechnungnummer: ' . $formular->r_num);

        //$this->set_left_header(($formular->stage == 1 ? "Angebot" : "Rechnung") . " Formular: " .
        //   ($formular->agency->type == 'person'
        //        ? $formular->agency->name . " " . $formular->agency->surname
        //       : $formular->agency->name));
        $this->content_view = "formular/final";
    }


    public function rechnung($id = 0)
    {
        $formular = Formular::find_by_id($id);

        if (!$formular) {
            show_404();
            return false;
        }

        $next_rnum = Config::find_by_param('next_rnum');

        $formular->r_num = $next_rnum->value++;
        $next_rnum->save();

        $formular->save();

        redirect("formular/final/" . $formular->id);
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

            redirect("formular/final/" . $formular->id);
        }

        $this->view_data['formular'] = $formular;
    }


    public function sendmail($v_num)
    {
        $emails = array($this->user->email);
        $input = $this->input->post("email");

        if (empty($input))
            redirect('');

        foreach ($input as $item)
            $emails[] = $item;

        $this->load->library("email");


        foreach ($emails as $email)
        {
            $this->email->clear();

            $this->email->from($this->user->email, $this->user->name . " " . $this->user->surname . " <" . $this->user->email . ">");
            $this->email->to($email);

            $this->email->subject('Subject');
            $this->email->attach('pdf/' . $v_num . "_" . $this->input->post('stage') . ".pdf");
            $this->email->send();
        }

        redirect('');
    }


}
