<?php

class Dashboard_Controller extends MY_Controller
{

    public function convert()
    {
        $hotels = array();

        /*        Hotel::delete_all();
        HotelRoomDifference::delete_all();
        HotelRoomDifferenceItem::delete_all();
        HotelChildAge::delete_all();
        HotelBonus::delete_all();
        HotelMinimum::delete_all();
        HotelRoom::delete_all();
        HotelRoomService::delete_all();
        HotelRoomType::delete_all();
        PeriodChildPrice::delete_all();
        PeriodServicePrice::delete_all();*/

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
                }
                else
                    $hotel = $hotels[$hotel_code]['hotel'];

                $room_code = $data[9];
                $room_name = $data[10];

                if (!isset($hotels[$hotel_code]['rooms'][$room_code]))
                {
                    $room = $hotels[$hotel_code]['rooms'][$room_code] = HotelRoom::create(array(
                        'hotel_id'=>$hotel->id,
                        'name'=>strtoupper($room_name)
                    ));
                }
                else
                    $room = $hotels[$hotel_code]['rooms'][$room_code];


            }
            fclose($handle);
        }

    }

    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');

        $this->convert();
    }

    public function index()
    {
        $this->view_data['page_title'] = 'Dashboard';
    }
}
