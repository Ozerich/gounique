<?php

class Formular extends MY_Controller
{

    public function create()
    {
        
    }

    public function open()
    {
        if($_POST)
        {
            redirect('formular/view/' . $_POST['vorgan']);
        }
    }

}
