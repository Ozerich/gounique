<?php

class User extends ActiveRecord\Model
{

    public static function generate_password($password)
    {
        $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_RAND));
        $hash = hash("sha256", $salt . $password);

        return $salt . $hash;
    }

    public function set_password($plain_text)
    {
        $this->hashed_password = $this->hash_password($plain_text);
    }

    private function hash_password($password)
    {
        $salt = bin2hex(mcrypt_create_iv(32, MCRYPT_RAND));
        $hash = hash("sha256", $salt . $password);

        return $salt . $hash;
    }

    private function validate_password($password)
    {
        $salt = substr($this->hashed_password, 0, 64);
        $hash = substr($this->hashed_password, 64, 64);

        $password_hash = hash("sha256", $salt . $password);

        return $password_hash == $hash;
    }

    public static function validate_login($email, $password, $user_id)
    {
        $user = User::find_by_email($email);

        if ($user && $user->validate_password($password) && $user->id == $user_id) {
            User::login($user->id);
            return $user;
        }
        else
            return FALSE;
    }

    public static function login($user_id)
    {
        $CI =& get_instance();
        $CI->session->set_userdata("user_id", $user_id);
    }

    public static function logout()
    {
        $CI =& get_instance();
        $CI->session->sess_destroy();
    }

    public function get_fullname()
    {
        return $this->name . " " . $this->surname;
    }

    public function get_initials()
    {
        return $this->name[0] . $this->surname[0];
    }
}

?>