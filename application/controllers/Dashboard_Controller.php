<?php

class Dashboard_Controller extends MY_Controller
{

    public function convert()
    {
        $hotels = array();
        /*
                        Hotel::delete_all();
                HotelRoomDifference::delete_all();
                HotelRoomDifferenceItem::delete_all();
                HotelChildAge::delete_all();
                HotelBonus::delete_all();
                HotelMinimum::delete_all();
                HotelRoom::delete_all();
                HotelRoomService::delete_all();
                HotelRoomType::delete_all();
                PeriodChildPrice::delete_all();
                PeriodServicePrice::delete_all();
                exit();

                $cc = 1;
                if (($handle = fopen("E:/hotel.csv", "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                        $hotel_code = $data[3];
                        if (!isset($hotels[$data[3]])) {
                            $hotel = Hotel::create(array(
                                'tlc' => $data[2],
                                'code' => $hotel_code,
                                'ort' => $data[6],
                                'name' => strtoupper($data[7]),
                                'stars' => str_replace(',', '.', $data[8])
                            ));
                            $hotels[$hotel->code] = array('rooms' => array(), 'hotel' => $hotel);
                            print_r($cc++." - ".$hotel->code."<br>");
                            flush();
                        }
                        else
                            $hotel = $hotels[$hotel_code]['hotel'];

                        $room_code = $data[9];
                        $room_name = $data[10];

                        if (!isset($hotels[$hotel_code]['rooms'][$room_name])) {
                            $room = $hotels[$hotel_code]['rooms'][$room_name] = HotelRoom::create(array(
                                'hotel_id' => $hotel->id,
                                'name' => strtoupper($room_name)
                            ));
                            for ($i = 0; $i <= 8; $i++) {
                                $roomtype = HotelRoomType::create(array(
                                    'hotel_id' => $hotel->id,
                                    'room_id' => $room->id,
                                    'code' => $room->code . $i,
                                    'count' => $i,
                                    'active' => 0
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
                            $room = $hotels[$hotel_code]['rooms'][$room_name];

                        $codierung = substr($room_code, -1);

                        $roomtype = HotelRoomType::find(array('conditions' => array('room_id = ? AND count = ?', $room->id, $codierung)));
                        $roomtype->active = TRUE;
                        $roomtype->save();

                    }
                    fclose($handle);
                }
        */

    }

    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');




/*
        foreach (Formular::all() as $formular) {
            $formular->brutto = $formular->brutto_price;

            if ($formular->prepayment) {
                $formular->prepayment_amount = $formular->brutto * $formular->prepayment / 100;
                if (!$formular->prepayment_date)
                    $formular->prepayment_date = $formular->departure_date->add(new DateInterval('P7D'));
            }
            else {
                $formular->prepayment_amount = 0;
                $formular->prepayment_date = null;
            }

            $formular->finalpayment_amount = $formular->brutto - $formular->prepayment_amount;

            if ($formular->provision) {
                $formular->provision_amount = $formular->brutto * $formular->provision / 100;
                $formular->provision_amount *= 1.19;
            }
            else
            {
                $formular->provision_amount = 0;
                $formular->provision_date = null;
            }

            if ($formular->departure_date) {
                if (!$formular->finalpayment_date)
                    $formular->finalpayment_date = $formular->departure_date->sub(new DateInterval('P35D'));

                if ($formular->finalpayment_date <= $formular->departure_date->add(new DateInterval('P3D')))
                    $formular->finalpayment_date = $formular->departure_date->add(new DateInterval('P3D'));
            }

            $formular->save();
        }*/

        //  $this->convert();
    }

    public function index()
    {
        $this->view_data['page_title'] = 'Dashboard';
    }
}
