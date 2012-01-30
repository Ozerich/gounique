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

    public function main()
    {
        $this->view_data['page_title'] = 'Hotels';
    }

    public function room($action = "", $room_id = "")
    {
        if ($action == "") {
            $this->view_data['rooms'] = ProductRoom::all();
        }
        elseif ($action == 'delete')
        {
            $room = ProductRoom::find_by_id($room_id);
            $room->delete();
            redirect('product/hotels/room');
        }
        elseif ($action == "search") {
            if ($_POST) {
                $this->view_data['search_text'] = $this->input->post('search_text');
                $s = $this->input->post('search_text');
                $this->view_data['rooms'] = ProductRoom::find('all', array('conditions' => array('name like "%' . $s . '%" OR code like "%' . $s . '%"')));
            }
            $action = '';
        }
        else if ($action == "create") {
            if ($_POST) {
                ProductRoom::create(array(
                    'code' => $this->input->post('code'),
                    'name' => $this->input->post('name'),
                    'min_pax' => $this->input->post('min_pax'),
                    'max_pax' => $this->input->post('max_pax'),
                    'min_erw' => $this->input->post('min_erw'),
                    'max_erw' => $this->input->post('max_erw'),
                    'capacity' => $this->input->post('capacity')
                ));

                redirect('product/hotels/room');
            }
            $this->view_data['rooms'] = ProductRoom::all();
        }
        elseif ($action == 'edit')
        {
            $room = ProductRoom::find_by_id($room_id);
            if (!$room) {
                show_404();
                return FALSE;
            }
            if ($_POST) {

                $room->code = $this->input->post('code');
                $room->name = $this->input->post('name');
                $room->min_pax = $this->input->post('min_pax');
                $room->max_pax = $this->input->post('max_pax');
                $room->min_erw = $this->input->post('min_erw');
                $room->max_erw = $this->input->post('max_erw');
                $room->capacity = $this->input->post('capacity');

                $room->save();

                redirect('product/hotels/room');
            }
            else
            {
                $this->view_data['room'] = $room;
            }
        }

        $this->set_page_tpl($action);
    }


    public function service($action = "", $service_id = "")
    {
        if ($action == "") {
            $this->view_data['services'] = ProductService::all();
        }
        elseif ($action == 'delete')
        {
            $service = ProductService::find_by_id($service_id);
            $service->delete();
            redirect('product/hotels/service');
        }
        elseif ($action == "search") {
            if ($_POST) {
                $this->view_data['search_text'] = $this->input->post('search_text');
                $s = $this->input->post('search_text');
                $this->view_data['services'] = ProductService::find('all', array('conditions' => array('name like "%' . $s . '%" OR code like "%' . $s . '%"')));
            }
            $action = '';
        }
        else if ($action == "create") {
            if ($_POST) {
                ProductService::create(array(
                    'code' => $this->input->post('code'),
                    'name' => $this->input->post('name'),
                ));

                redirect('product/hotels/service');
            }
            $this->view_data['services'] = ProductService::all();
        }
        elseif ($action == 'edit')
        {
            $service = ProductService::find_by_id($service_id);
            if (!$service) {
                show_404();
                return FALSE;
            }
            if ($_POST) {

                $service->code = $this->input->post('code');
                $service->name = $this->input->post('name');

                $service->save();

                redirect('product/hotels/service');
            }
            else
            {
                $this->view_data['service'] = $service;
            }
        }

        $this->set_page_tpl($action);
    }

    public function hotel($action = "", $hotel_id = "")
    {
        if ($action == "") {
            $this->view_data['services'] = ProductService::all();
        }
        elseif ($action == 'delete')
        {
            $service = ProductHotel::find_by_id($hotel_id);
            $service->delete();
            redirect('product/hotels');
        }
        elseif ($action == "search") {
            if ($_POST) {
                $this->view_data['search_text'] = $this->input->post('search_text');
                $s = $this->input->post('search_text');
                $this->view_data['services'] = ProductService::find('all', array('conditions' => array('name like "%' . $s . '%" OR code like "%' . $s . '%"')));
            }
            $action = '';
        }
        else if ($action == "create") {
            if ($_POST) {
                ProductService::create(array(
                    'code' => $this->input->post('code'),
                    'name' => $this->input->post('name'),
                ));

                redirect('product/hotels/service');
            }
            $this->view_data['services'] = ProductService::all();
        }
        elseif ($action == 'edit')
        {
            $service = ProductService::find_by_id($hotel_id);
            if (!$service) {
                show_404();
                return FALSE;
            }
            if ($_POST) {

                $service->code = $this->input->post('code');
                $service->name = $this->input->post('name');

                $service->save();

                redirect('product/hotels/service');
            }
            else
            {
                $this->view_data['service'] = $service;
            }
        }

        $this->set_page_tpl($action == "main" ? "/main" : $action);
    }
}
