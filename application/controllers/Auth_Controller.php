<?php

class Auth_Controller extends MY_Controller
{
    public function login()
    {

        if ($_POST) {
            $user = User::validate_login($_POST['email'], $_POST['password'], $_POST['user_id']);

            if ($user)
                redirect('');
            else
                redirect('login');
        }

        $this->layout_view = '';
    }

    public function logout()
    {
        User::logout();

        redirect('');
    }
}

?>
