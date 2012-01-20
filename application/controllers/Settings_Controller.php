<?php

class Settings_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->user)
            redirect('login');
    }

    private function save_data($filename)
    {
        $f = fopen($filename, "r+");

        $i = 0;
        while (($data = fgetcsv($f, 1000, ";")) !== false)
        {

            $hotel_code = trim($data[3]);
            $hotel_name = trim($data[7]);
            $hotel_stars = $data[8];

            $hotel = Hotel::find_by_code($hotel_code);
            if (!$hotel)
                $hotel = Hotel::create(
                    array(
                        'code' => $hotel_code,
                        'name' => $hotel_name,
                        'stars' => $hotel_stars
                    )
                );

            $capacity = trim($data[9]);
            $room_capacity = RoomCapacity::find_by_value($capacity);

            if (!$room_capacity)
                $room_capacity = RoomCapacity::create(array(
                    'value' => $capacity
                ));

            $type = trim($data[10]);
            $room_type = RoomType::find_by_value($type);

            if (!$room_type)
                $room_type = RoomType::create(array(
                    'value' => $type
                ));

            $service = trim($data[11]);
            $service_full = trim($data[12]);
            $hotel_service = HotelService::find_by_value($service);

            if (!$hotel_service)
                $hotel_service = HotelService::create(array(
                    'value' => $service,
                    'full_name' => $service_full
                ));

            $price = $data[5];
            $date = trim($data[0]);

            HotelOffer::create(array(
               'hotel_id' => $hotel->id,
               'roomcapacity' => $room_capacity->id,
               'roomtype' => $room_type->id,
               'hotelservice_id' => $hotel_service->id,
               'date' => $date,
               'price' => $price,
            ));

        }

        fclose($f);

        unlink($filename);
    }

    public function offers()
    {

                $this->save_data('csv/hotel.csv');

        $this->view_data['page_title'] = 'Settings';
    }

    public function upload_csv()
    {

    }
}
