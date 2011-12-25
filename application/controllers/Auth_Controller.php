<?php

class Auth_Controller extends MY_Controller
{
    public function login()
    {
        if ($_POST) {
            $user = User::validate_login($_POST['email'], $_POST['password']);

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
