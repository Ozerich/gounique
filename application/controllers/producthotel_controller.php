<?php

class ProductHotel_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');

        $this->view_data['JS_files'] = array("js/product.js");
    }

    public function index()
    {
        $this->view_data['page_title'] = 'Hotels';
        $this->view_data['hotel_list'] = $this->load->view('producthotel/hotel_list.php', array('hotels' => Hotel::all()), true);
    }

    public function search_hotel()
    {
        $s = $this->input->post('search');

        $hotels = Hotel::find('all', array('conditions' => array('code like "%' . $s . '%" OR name like "%' . $s . '%"')));

        echo $this->load->view('producthotel/hotel_list.php', array('hotels' => $hotels), true);
        exit();
    }

    public function tlc_search($search_str = '')
    {
        $airports = Airport::find('all', array('conditions' => array('code like "%' . $search_str . '%"')));
        $result = array();
        foreach ($airports as $airport)
            $result[] = array("text" => "<b>" . $airport->code . "</b> - " . $airport->name, "value" => $airport->code);
        echo json_encode($result);
        exit();


    }

    public function edit($id = 0)
    {
        $hotel = Hotel::find_by_id($id);
        if (!$hotel) {
            show_404();
            return false;
        }

        if ($_POST) {
            $hotel->code = $this->input->post('code');
            $hotel->name = $this->input->post('name');
            $hotel->stars = $this->input->post('stars');
            $hotel->tlc = $this->input->post('tlc');
            $hotel->zielgebiet = $this->input->post('zielgebiet');
            $hotel->ort = $this->input->post('ort');
            $hotel->land = $this->input->post('land');
            $hotel->flugbindung = $this->input->post('flugbindung');
            $hotel->active = $this->input->post('crs');
            $hotel->xmas_dinner = $this->input->post('xmas_dinner');
            $hotel->newyear_dinner = $this->input->post('newyear_dinner');
            $hotel->konti_typ = $this->input->post('kontityp');
            $hotel->incoming = $this->input->post('incoming');
            $hotel->optionsbuchung = $this->input->post('optionsbuchung');
            $hotel->rq_buchung = $this->input->post('rq_buchung');
            $hotel->kontakt_vorname = $this->input->post('kontakt_vorname');
            $hotel->kontakt_nachname = $this->input->post('kontakt_nachname');
            $hotel->kontakt_strasse = $this->input->post('kontakt_strasse');
            $hotel->kontakt_postleitzahl = $this->input->post('kontakt_postleitzahl');
            $hotel->kontakt_ort = $this->input->post('kontakt_ort');
            $hotel->kontakt_land = $this->input->post('kontakt_land');
            $hotel->kontakt_phone = $this->input->post('kontakt_phone');
            $hotel->kontakt_fax = $this->input->post('kontakt_fax');
            $hotel->kontakt_email = $this->input->post('kontakt_email');
            $hotel->kontakt_homepage = $this->input->post('kontakt_homepage');
            $hotel->teenblock_active = isset($_POST['teenblock_active']) ? 1 : 0;
            $hotel->childblock_active = isset($_POST['childblock_active']) ? 1 : 0;
            $hotel->infantblock_active = isset($_POST['infantblock_active']) ? 1 : 0;

            $hotel->changed_by = $this->user->id;
            $hotel->changed_time = time_to_mysqldatetime(time());

            $hotel->save();

            HotelMinimum::table()->delete(array('hotel_id' => $id));

            foreach (array('teen', 'child', 'infant') as $ct)
                if ($this->input->post($ct . '-von'))
                    foreach ($this->input->post($ct . '-von') as $ind => $child)
                    {
                        $child_age = isset($_POST[$ct . '_id'][$ind]) ? HotelChildAge::find_by_id($_POST[$ct . '_id'][$ind]) :
                            HotelChildAge::create(array('hotel_id' => $id));

                        $child_age->hotel_id = $id;
                        $child_age->von = $_POST[$ct . '-von'][$ind];
                        $child_age->bis = $_POST[$ct . '-bis'][$ind];
                        $child_age->active = isset($_POST[$ct . '-active'][$ind]) ? 1 : 0;
                        $child_age->type = $ct;
                        $child_age->save();
                    }

            if ($this->input->post('minimum_von'))
                foreach ($this->input->post('minimum_von') as $ind => $minimum)
                    if ($_POST['minimum_von'][$ind] && $_POST['minimum_bis'][$ind])
                        HotelMinimum::create(array(
                            'hotel_id' => $id,
                            'von' => inputdate_to_mysqldate($_POST['minimum_von'][$ind]),
                            'bis' => inputdate_to_mysqldate($_POST['minimum_bis'][$ind]),
                            'nights' => $_POST['minimum_nights'][$ind],
                        ));

            HotelBonus::table()->delete(array('hotel_id' => $id));
            if ($this->input->post('bonustype'))
                foreach ($this->input->post('bonustype') as $ind => $bonus_type)
                {
                    $bonus = array(
                        'hotel_id' => $id,
                        'type' => $bonus_type,
                        'period_start' => inputdate_to_mysqldate($_POST['bonus_von'][$ind]),
                        'period_finish' => inputdate_to_mysqldate($_POST['bonus_bis'][$ind])
                    );

                    switch ($bonus_type)
                    {
                        case "night_bonus":
                            $bonus['night_1'] = $_POST['from_nights'][$ind];
                            $bonus['night_2'] = $_POST['to_nights'][$ind];
                            break;

                        case "earlybird_days":
                            $bonus['days_before'] = $_POST['days_before'][$ind];
                            $bonus['discount_1'] = $_POST['discount1'][$ind];
                            break;

                        case "earlybird_date":
                            $bonus['booking_till'] = inputdate_to_mysqldate($_POST['booking_till'][$ind]);
                            $bonus['discount_2'] = $_POST['discount2'][$ind];
                            break;

                        case "long_stay":
                            $bonus['days_count'] = $_POST['days_count'][$ind];
                            $bonus['discount_3'] = $_POST['discount3'][$ind];
                            break;

                        case "turbo_bonus":
                            $bonus['booking_till_2'] = inputdate_to_mysqldate($_POST['booking_till_2'][$ind]);
                            $bonus['discount_4'] = $_POST['discount4'][$ind];
                            break;
                    }

                    HotelBonus::create($bonus);
                }

            redirect('product/hotel');
        }

        $this->view_data['hotel'] = $hotel;
    }

    public function create()
    {
        if ($_POST) {

            $hotel = Hotel::create(array(
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'stars' => $this->input->post('stars'),
                'tlc' => $this->input->post('tlc'),
                'zielgebiet' => $this->input->post('zielgebiet'),
                'ort' => $this->input->post('ort'),
                'land' => $this->input->post('land'),
                'flugbindung' => $this->input->post('flugbindung'),
                'active' => $this->input->post('crs'),
                'xmas_dinner' => $this->input->post('xmas_dinner'),
                'newyear_dinner' => $this->input->post('newyear_dinner'),
                'konti_typ' => $this->input->post('kontityp'),
                'incoming' => $this->input->post('incoming'),
                'optionsbuchung' => $this->input->post('optionsbuchung'),
                'rq_buchung' => $this->input->post('rq_buchung'),
                'kontakt_vorname' => $this->input->post('kontakt_vorname'),
                'kontakt_nachname' => $this->input->post('kontakt_nachname'),
                'kontakt_strasse' => $this->input->post('kontakt_strasse'),
                'kontakt_postleitzahl' => $this->input->post('kontakt_postleitzahl'),
                'kontakt_ort' => $this->input->post('kontakt_ort'),
                'kontakt_land' => $this->input->post('kontakt_land'),
                'kontakt_phone' => $this->input->post('kontakt_phone'),
                'kontakt_fax' => $this->input->post('kontakt_fax'),
                'kontakt_email' => $this->input->post('kontakt_email'),
                'kontakt_homepage' => $this->input->post('kontakt_homepage'),
                'teenblock_active' => isset($_POST['teenblock_active']) ? 1 : 0,
                'childblock_active' => isset($_POST['childblock_active']) ? 1 : 0,
                'infantblock_active' => isset($_POST['infantblock_active']) ? 1 : 0,
            ));

            $hotel_id = $hotel->id;
            if ($this->input->post('teen-von'))
                foreach ($this->input->post('teen-von') as $ind => $teen)
                    HotelChildAge::create(array(
                        'hotel_id' => $hotel_id,
                        'von' => $_POST['teen-von'][$ind],
                        'bis' => $_POST['teen-bis'][$ind],
                        'active' => isset($_POST['teen-active'][$ind]) ? 1 : 0,
                        'type' => 'teen'
                    ));

            if ($this->input->post('child-von'))
                foreach ($this->input->post('child-von') as $ind => $child)
                    HotelChildAge::create(array(
                        'hotel_id' => $hotel_id,
                        'von' => $_POST['child-von'][$ind],
                        'bis' => $_POST['child-bis'][$ind],
                        'active' => isset($_POST['child-active'][$ind]) ? 1 : 0,
                        'type' => 'child'
                    ));

            if ($this->input->post('infant-von'))
                foreach ($this->input->post('infant-von') as $ind => $infant)
                    HotelChildAge::create(array(
                        'hotel_id' => $hotel_id,
                        'von' => $_POST['infant-von'][$ind],
                        'bis' => $_POST['infant-bis'][$ind],
                        'active' => isset($_POST['infant-active'][$ind]) ? 1 : 0,
                        'type' => 'infant'
                    ));

            if ($this->input->post('minimum_von'))
                foreach ($this->input->post('minimum_von') as $ind => $minimum)
                    HotelMinimum::create(array(
                        'hotel_id' => $hotel_id,
                        'von' => inputdate_to_mysqldate($_POST['minimum_von'][$ind]),
                        'bis' => inputdate_to_mysqldate($_POST['minimum_bis'][$ind]),
                        'nights' => inputdate_to_mysqldate($_POST['minimum_nights'][$ind]),
                    ));
            if ($this->input->post('bonustype'))
                foreach ($this->input->post('bonustype') as $ind => $bonus_type)
                {
                    $bonus = array(
                        'hotel_id' => $hotel_id,
                        'type' => $bonus_type,
                        'period_start' => inputdate_to_mysqldate($_POST['bonus_von'][$ind]),
                        'period_finish' => inputdate_to_mysqldate($_POST['bonus_bis'][$ind])
                    );

                    switch ($bonus_type)
                    {
                        case "night_bonus":
                            $bonus['night_1'] = $_POST['from_nights'][$ind];
                            $bonus['night_2'] = $_POST['to_nights'][$ind];
                            break;

                        case "earlybird_date":
                            $bonus['days_before'] = $_POST['days_before'][$ind];
                            $bonus['discount_1'] = $_POST['discount1'][$ind];
                            break;

                        case "earlybird_days":
                            $bonus['booking_till'] = inputdate_to_mysqldate($_POST['booking_till'][$ind]);
                            $bonus['discount_2'] = $_POST['discount2'][$ind];
                            break;

                        case "long_stay":
                            $bonus['days_count'] = $_POST['days_count'][$ind];
                            $bonus['discount_3'] = $_POST['discount3'][$ind];
                            break;

                        case "turbo_bonus":
                            $bonus['booking_till_2'] = inputdate_to_mysqldate($_POST['booking_till_2'][$ind]);
                            $bonus['discount_4'] = $_POST['discount4'][$ind];
                            break;
                    }

                    HotelBonus::create($bonus);
                }
            redirect('product/hotel');
        }
    }

    public function rooms($id = 0, $room_id = 0)
    {
        $hotel = Hotel::find_by_id($id);

        if (!$hotel) {
            show_404();
            return FALSE;
        }

        $room = $room_id == 0 ? HotelRoomType::find_by_hotel_id($id) : HotelRoomType::find_by_id($room_id);

        if ($room && $room->hotel_id != $id) {
            show_404();
            return FALSE;
        }

        if ($_POST) {

            $start_date = inputdate_to_mysqldate($this->input->post('von'));
            $finish_date = inputdate_to_mysqldate($this->input->post('bis'));

            $period_id = 0;

            if ($this->input->post('edit-submit') != '')
                $period_id = $this->input->post('period_id');
            else
            {
                $period = RoomPeriod::find(array('start' => $start_date, 'finish' => $finish_date));

                if ($period)
                    $period_id = $period->id;
                else {
                    $period = RoomPeriod::create(array(
                        'room_id' => $room_id,
                        'start' => $start_date,
                        'finish' => $finish_date));
                    $period_id = $period->id;
                }
            }

            $period = RoomPeriod::find_by_id($period_id);
            $period->start = $start_date;
            $period->finish = $finish_date;
            $period->zimmer_kontigent = $this->input->post('zimmerkontigent');
            $period->relis = $this->input->post('relis');
            $period->price_marge = $this->input->post('marge_price');
            $period->price_erm = $this->input->post('erm_price');
            $period->meal_marge = $this->input->post('marge_meal');
            $period->price = $this->input->post('erw_price');
            $period->save();

            $period_id = $period->id;

            PeriodChildPrice::table()->delete(array('period_id' => $period_id));
            if ($this->input->post('price1'))
                foreach ($this->input->post('price1') as $age_id => $data)
                {
                    PeriodChildPrice::create(array(
                        'period_id' => $period_id,
                        'age_id' => $age_id,
                        'price_1' => $_POST['price1'][$age_id] != '' ? $_POST['price1'][$age_id] : $period->price,
                        'price_2' => $_POST['price2'][$age_id] != '' ? $_POST['price2'][$age_id] : $period->price,
                    ));
                }

            PeriodServicePrice::table()->delete(array('period_id' => $period_id));
            foreach ($this->input->post('meal') as $age_id => $data)
                foreach ($data as $service_id => $price)
                    PeriodServicePrice::create(array(
                        'period_id' => $period_id,
                        'age_id' => $age_id,
                        'service_id' => $service_id,
                        'price' => $price
                    ));


            redirect('product/hotel/rooms/' . $id . '/' . $room_id);
        }


        $this->view_data['hotel'] = $hotel;
        $this->view_data['room'] = $room;

    }

    public function save_difference($room_id = 0)
    {
        $room = HotelRoomType::find_by_id($room_id);

        if (!$room) {
            show_404();
            return FALSE;
        }

        HotelRoomDifference::table()->delete(array('room_id' => $room_id));
        HotelRoomDifferenceItem::table()->delete(array('room_id' => $room_id));

        if ($_POST && isset($_POST['diff'])) {
            foreach ($_POST['diff'][0] as $ind => $val)
            {

                $rd = HotelRoomDifference::create(array('room_id' => $room_id));
                foreach ($_POST['diff'] as $i => $data)
                    HotelRoomDifferenceItem::create(array(
                        'room_difference_id' => $rd->id,
                        'room_id' => $room->id,
                        'childage_id' => $i,
                        'value' => $data[$ind]
                    ));
            }
            redirect('product/hotel/rooms/' . $room->hotel_id . "/" . $room_id);
        }
        else
            show_404();
    }

    public function room($hotel_id = 0, $room_id = 0)
    {
        $hotel = Hotel::find_by_id($hotel_id);

        if (!$hotel) {
            show_404();
            return FALSE;
        }

        if ($_POST) {

            if ($room_id == 0) {
                $room = HotelRoom::create(array(
                    'hotel_id' => $hotel_id,
                    'name' => strtoupper($this->input->post('roomname')),
                    'code' => strtoupper($this->input->post('code')),
                ));

                foreach (Service::all() as $service)
                    HotelRoomService::create(array(
                        'room_id' => $room->id,
                        'service_id' => $service->id,
                        'active' => isset($_POST['room_service'][$service->id])
                    ));

                for ($i = 0; $i <= Config::get('max_zimmer_count'); $i++)
                {
                    $active = isset($_POST['room_count'][$i]);
                    $roomtype = HotelRoomType::create(array(
                        'room_id' => $room->id,
                        'hotel_id' => $hotel->id,
                        'code' => $room->code . $i,
                        'count' => $i,
                        'active' => $active
                    ));

                    $people_count = $i == 0 ? 2 : $i;
                    $hd = HotelRoomDifference::create(array('room_id' => $roomtype->id));
                    HotelRoomDifferenceItem::create(array(
                        'room_difference_id' => $hd->id,
                        'room_id' => $roomtype->id,
                        'childage_id' => 0,
                        'value' => $people_count));

                }
            }
            else
            {
                $room = HotelRoom::find_by_id($room_id);
                $room->name = $this->input->post('roomname');
                $room->code = $this->input->post('code');
                $room->save();

                foreach (Service::all() as $service)
                {
                    $room_service = HotelRoomService::find(array('conditions' => array('room_id = ? AND service_id = ?', $room->id, $service->id)));

                    $room_service->active = isset($_POST['room_service'][$service->id]);
                    $room_service->save();
                }

                for ($i = 0; $i <= Config::get('max_zimmer_count'); $i++)
                {
                    $type = HotelRoomType::find(array('conditions' => array('room_id = ? AND count = ?', $room->id, $i)));
                    $type->active = isset($_POST['room_count'][$i]);
                    $type->code = $room->code.$i;
                    $type->save();
                }
            }
            redirect('product/hotel/rooms/' . $hotel_id);
        }

        $this->view_data['hotel'] = $hotel;
        $this->view_data['room'] = $room_id ? HotelRoom::find_by_id($room_id) : null;
    }

    public function ajax_period($period_id = 0)
    {
        $period = RoomPeriod::find_by_id($period_id);

        if (!$period) {
            exit();
        }

        $data = array();

        $price = PeriodServicePrice::find_all_by_period_id($period_id);

        foreach ($price as $item)
            $data[$item->age_id][$item->service_id] = $item->price;
        foreach ($data as $age_id => $t)
        {
            if ($age_id == 0)
                continue;

            $price = PeriodChildPrice::find(array('period_id' => $period_id, 'age_id' => $age_id));
            $data[$age_id]['price'] = array('1' => $price->price_1, '2' => $price->price_2);
        }

        echo json_encode($data);
        exit();
    }
}
