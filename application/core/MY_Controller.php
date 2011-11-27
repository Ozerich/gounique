<?php

class MY_Controller extends CI_Controller
{
    var $user = FALSE;

    public function __construct()
    {
        parent::__construct();

        $this->user = $this->session->userdata('user_id') ? User::find($this->session->userdata('user_id')) : FALSE;
    }
}

?>