<?php

class MY_Controller extends CI_Controller
{
    var $user = FALSE;

    protected $layout_view = "application";
    protected $content_view = "";
    protected $view_data = array();

    public function __construct()
    {
        parent::__construct();

        $this->user = $this->session->userdata('user_id') ? User::find($this->session->userdata('user_id')) : FALSE;

        $this->view_data['user'] = $this->user;
    }

    public function _output($output)
    {
        $this->view_data['current_page'] = $this->router->class."_".$this->router->method;
        if ($this->content_view !== FALSE && empty($this->content_view))
            $this->content_view = $this->router->class . "/" . $this->router->method;

        $content = file_exists(APPPATH . "views/" . $this->content_view . EXT)
                ? $this->load->view($this->content_view, $this->view_data, TRUE) : FALSE;

        if($this->layout_view)
            echo $this->load->view('layouts/'. $this->layout_view, array("main_content" => $content), TRUE);
        else
            echo $content;
    }
}

?>