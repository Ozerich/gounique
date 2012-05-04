<?php

class Flight_Controller extends MY_Controller
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
        $this->view_data['page_title'] = 'Flights';
        $this->view_data['flight_list'] = $this->load->view('flight/flight_list.php', array('flights' => Flight::all()), true);
    }

    public function flight($flight_id = 0)
    {
        $flight = Flight::find_by_id($flight_id);
        if (!$flight)
            show_404();

        $this->view_data['flight'] = $flight;
        $this->view_data['flight_days'] = $this->load->view('flight/flight_days.php', array('days' => $flight->days), true);
    }

    public function period()
    {
        if ($_POST) {
            $date_start = $this->input->post('period_start');
            $date_finish = $this->input->post('period_finish');

            $date = mktime(0, 0, 0, substr($date_start, 2, 2), substr($date_start, 0, 2), substr($date_start, 4));
            $date_finish = mktime(0, 0, 0, substr($date_finish, 2, 2), substr($date_finish, 0, 2), substr($date_finish, 4));

            $time_departure = $this->input->post('departure_time');
            $time_arrive = $this->input->post('arrival_time');
            $release = $this->input->post('release');
            $konti = $this->input->post('konti');
            $max_dauer = $this->input->post('max_dauer');

            $price = substr($_POST['price'], 0, -1);
            $price = explode('|', $price);
            $price_ms = array();
            foreach ($price as $price_item)
                $price_ms[substr($price_item, 0, strpos($price_item, '_'))] = substr($price_item, strpos($price_item, '_') + 1);
            $price = serialize($price_ms);

            $class_discounts = array();
            foreach ($_POST['class'] as $val)
                $class_discounts[] = $val;
            $class_discounts = serialize($class_discounts);

            $flight_id = $this->input->post('flight_id');

            while ($date <= $date_finish) {
                $date_obj = getdate($date);
                $dayweek = $date_obj['wday'];
                $dayweek = $dayweek == 0 ? 7 : $dayweek;
                if (!isset($_POST['weekday'][$dayweek])) {
                    $date += 60 * 60 * 24;
                    continue;
                }
                $date_str = $date_obj['year'] . '-' . $date_obj['mon'] . '-' . $date_obj['mday'];

                FlightDay::table()->delete(array('flight_id' => $flight_id, 'date' => $date_str));
                FlightDay::create(array(
                    'flight_id' => $flight_id,
                    'date' => $date_str,
                    'time_departure' => $time_departure,
                    'time_arrive' => $time_arrive,
                    'release' => $release,
                    'konti' => $konti,
                    'max_dauer' => $max_dauer,
                    'price' => $price,
                    'class_discounts' => $class_discounts,
                ));


                $date += 60 * 60 * 24;
            }

            echo $this->load->view('flight/flight_days.php', array('days' => Flight::find_by_id($flight_id)->days), true);
            exit();
        }
        else
            show_404();
    }

    public function delete_period($flight_id = 0)
    {
        $flight = Flight::find_by_id($flight_id);
        if($_POST && $flight)
        {
            $date_start = $this->input->post('period_start');
            $date_finish = $this->input->post('period_finish');

            $date = mktime(0, 0, 0, substr($date_start, 2, 2), substr($date_start, 0, 2), substr($date_start, 4));
            $date_finish = mktime(0, 0, 0, substr($date_finish, 2, 2), substr($date_finish, 0, 2), substr($date_finish, 4));

            while ($date <= $date_finish) {
                $date_obj = getdate($date);
                $date_str = $date_obj['year'] . '-' . $date_obj['mon'] . '-' . $date_obj['mday'];
                $dayweek = $date_obj['wday'];
                $dayweek = $dayweek == 0 ? 7 : $dayweek;
                if (!isset($_POST['weekday'][$dayweek])) {
                    $date += 60 * 60 * 24;
                    continue;
                }

                FlightDay::table()->delete(array('flight_id' => $flight_id, 'date' => $date_str));

                $date += 60 * 60 * 24;
            }

            echo $this->load->view('flight/flight_days.php', array('days' => Flight::find_by_id($flight_id)->days), true);
            die;
        }
        show_404();
    }

    public function new_flight()
    {
        if ($_POST) {
            $flight = Flight::create(array(
                'flug_num' => $this->input->post('flug_num'),
                'carrier' => $this->input->post('carrier'),
                'tlc_from' => $this->input->post('tlc_from'),
                'tlc_to' => $this->input->post('tlc_to'),
                'int_num' => $this->input->post('int_num'),
                'marge' => $this->input->post('marge'),
                'tax_1' => $this->input->post('tax_1'),
                'tax_2' => $this->input->post('tax_2'),
                'tax_3' => $this->input->post('tax_3'),
                'tax_4' => $this->input->post('tax_4'),
                'active' => isset($_POST['crs']) ? 1 : 0,
                'hotel_bindung' => isset($_POST['hotel_bindung']) ? 1 : 0,
            ));

            $pos = 0;
            if (isset($_POST['from']))
                foreach ($_POST['from'] as $ind => $v)
                    FlightAge::create(array(
                        'flight_id' => $flight->id,
                        'pos' => ++$pos,
                        'from' => $_POST['from'][$ind],
                        'to' => $_POST['to'][$ind],
                        'tax_need' => isset($_POST['tax_need'][$ind]) ? 1 : 0
                    ));

            echo $this->load->view('flight/flight_list.php', array('flights' => Flight::all()), true);
            die;
        }
        else
            show_404();
    }

    public function search_flight()
    {
        $s = $this->input->post('search');

        $flights = Flight::find('all', array('conditions' => array('carrier like "%' . $s . '%" OR flug_num like "%' . $s . '%"')));

        echo $this->load->view('flight/flight_list.php', array('flights' => $flights), true);
        exit();
    }


    function edit_flight($flight_id = 0)
    {
        $flight = Flight::find_by_id($flight_id);
        if (!$flight)
            show_404();

        if ($_POST) {
            $flight->flug_num = $this->input->post('flug_num');
            $flight->carrier = $this->input->post('carrier');
            $flight->tlc_from = $this->input->post('tlc_from');
            $flight->tlc_to = $this->input->post('tlc_to');
            $flight->int_num = $this->input->post('int_num');
            $flight->marge = $this->input->post('marge');
            $flight->tax_1 = $this->input->post('tax_1');
            $flight->tax_2 = $this->input->post('tax_2');
            $flight->tax_3 = $this->input->post('tax_3');
            $flight->tax_4 = $this->input->post('tax_4');
            $flight->active = isset($_POST['crs']) ? 1 : 0;
            $flight->hotel_bindung = isset($_POST['hotel_bindung']) ? 1 : 0;
            $flight->save();

            FlightAge::table()->delete(array('flight_id' => $flight->id));
            $pos = 0;
            if (isset($_POST['from']))
                foreach ($_POST['from'] as $ind => $v)
                    FlightAge::create(array(
                        'flight_id' => $flight->id,
                        'pos' => ++$pos,
                        'from' => $_POST['from'][$ind],
                        'to' => $_POST['to'][$ind],
                        'tax_need' => isset($_POST['tax_need'][$ind]) ? 1 : 0
                    ));

            echo $this->load->view('flight/flight_list.php', array('flights' => Flight::all()), true);
            die;
        }
        else {
            echo $this->load->view('flight/edit_flight.php', array('flight' => $flight), true);
            die;
        }
    }


}
