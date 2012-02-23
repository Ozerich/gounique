<?php

class MY_Controller extends CI_Controller
{
    var $user = FALSE;

    protected $layout_view = "application";
    protected $content_view = "";
    protected $view_data = array();

    private $template_path;


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
            $this->content_view = $controller_class  .  ($this->template_path && $this->template_path[0] == "/" ? '' : '/'.str_replace('_','',$this->router->method)). (($this->template_path) ? '/'.$this->template_path : '');
       // print_r(APPPATH . "views/" . $this->content_view . EXT);exit();
        $content = file_exists(APPPATH . "views/" . $this->content_view . EXT)
                        ? $this->load->view($this->content_view, $this->view_data, TRUE) : FALSE;

        if($this->layout_view)
            echo $this->load->view('layouts/'. $this->layout_view, array("page_content" => $content), TRUE);
        else
            echo $content;
    }

    protected function set_page_title($title)
    {
        $this->view_data['page_title'] = $title;
    }

    protected function set_page_tpl($path)
    {
        $this->template_path = $path;
    }
}

?>