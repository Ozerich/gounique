<?php

class MY_Controller extends CI_Controller
{
    var $user = FALSE;

    protected $layout_view = "application";
    protected $content_view = "";
    protected $view_data = array();

    protected $left_header = "";
    protected $right_header = "";

    public function __construct()
    {
        parent::__construct();

        $this->user = $this->session->userdata('user_id') ? User::find($this->session->userdata('user_id')) : FALSE;
        $this->view_data['user'] = $this->user;
    }

    public function _output($output)
    {

        $this->view_data['current_page'] = $this->router->class."_".$this->router->method;


        $controller_class = strpos(strtolower($this->router->class), '_controller') !== FALSE ? substr($this->router->class, 0, -11) : $this->router->class;

        if ($this->content_view !== FALSE && empty($this->content_view))
            $this->content_view = $controller_class . "/" . $this->router->method;

        $this->view_data['left_header'] = $this->left_header;
        $this->view_data['right_header'] = $this->right_header;

        $content = file_exists(APPPATH . "views/" . $this->content_view . EXT)
                        ? $this->load->view($this->content_view, $this->view_data, TRUE) : FALSE;

        if($this->layout_view)
            echo $this->load->view('layouts/'. $this->layout_view, array("main_content" => $content), TRUE);
        else
            echo $content;
    }

    protected function set_left_header($plaintext)
    {
        $this->left_header = $plaintext;
    }

    protected function set_right_header($plaintext)
    {
        $this->right_header = $plaintext;
    }


    protected function set_page_title($title)
    {
        $this->view_data['page_title'] = $title;
    }
}

?>