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
        $this->view_data['hotels'] = Hotel::all();
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
            $hotel->zielgebiet = $this->input->post('zielgibiet');
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
            $hotel->save();

            HotelChildAge::table()->delete(array('hotel_id' => $id));
            HotelMinimum::table()->delete(array('hotel_id' => $id));

            if ($this->input->post('teen-von'))
                foreach ($this->input->post('teen-von') as $ind => $teen)
                    HotelChildAge::create(array(
                        'hotel_id' => $id,
                        'von' => $_POST['teen-von'][$ind],
                        'bis' => $_POST['teen-bis'][$ind],
                        'active' => isset($_POST['teen-active'][$ind]) ? 1 : 0,
                        'type' => 'teen'
                    ));

            if ($this->input->post('child-von'))
                foreach ($this->input->post('child-von') as $ind => $child)
                    HotelChildAge::create(array(
                        'hotel_id' => $id,
                        'von' => $_POST['child-von'][$ind],
                        'bis' => $_POST['child-bis'][$ind],
                        'active' => isset($_POST['child-active'][$ind]) ? 1 : 0,
                        'type' => 'child'
                    ));

            if ($this->input->post('infant-von'))
                foreach ($this->input->post('infant-von') as $ind => $infant)
                    HotelChildAge::create(array(
                        'hotel_id' => $id,
                        'von' => $_POST['infant-von'][$ind],
                        'bis' => $_POST['infant-bis'][$ind],
                        'active' => isset($_POST['infant-active'][$ind]) ? 1 : 0,
                        'type' => 'infant'
                    ));

            if ($this->input->post('minimum_von'))
                foreach ($this->input->post('minimum_von') as $ind => $minimum)
                    HotelMinimum::create(array(
                        'hotel_id' => $id,
                        'von' => inputdate_to_mysqldate($_POST['minimum_von'][$ind]),
                        'bis' => inputdate_to_mysqldate($_POST['minimum_bis'][$ind]),
                        'nights' => $_POST['minimum_nights'][$ind],
                    ));
        }

        $this->view_data['hotel'] = $hotel;
    }

    public function create()
    {
        if ($_POST) {
            $hotel = ProductHotel::create(array(
                'code' => $this->input->post('code'),
                'name' => $this->input->post('name'),
                'stars' => $this->input->post('stars'),
                'tlc' => $this->input->post('tlc'),
                'zielgebiet' => $this->input->post('zielgibiet'),
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
                foreach($_POST['diff'] as $i => $data)
                    HotelRoomDifferenceItem::create(array(
                        'room_difference_id' => $rd->id,
                        'room_id' => $room->id,
                        'childage_id' => $i,
                        'value' => $data[$ind]
                    ));
            }
            redirect('product/hotel/rooms/'.$room->hotel_id."/".$room_id);
        }
        else
            show_404();
    }

    public function create_room($hotel_id = 0)
    {
        $hotel = Hotel::find_by_id($hotel_id);

        if (!$hotel) {
            show_404();
            return FALSE;
        }

        if ($_POST) {
            $room = HotelRoom::create(array(
                'hotel_id' => $hotel_id,
                'name' => $this->input->post('roomname')
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

                if ($active) {
                    HotelRoomType::create(array(
                        'room_id' => $room->id,
                        'hotel_id' => $hotel->id,
                        'code' => $room->code . $i
                    ));
                }
            }

            redirect('product/hotel/rooms/' . $hotel_id);

        }

        $this->view_data['hotel'] = $hotel;
    }
}
