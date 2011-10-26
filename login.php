<?

if (isset($_SESSION['auth']) && $_SESSION['auth'] == true)
    header("Location: index.php");

require "lib/init.php";

if (isset($_POST['login-submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    foreach ($ALL_USERS as $user)
    {
        if ($email == $user['email'] && $password == $user['password']) {
            $_SESSION['auth'] = true;
            $_SESSION['user'] = array("email" => $email, "fullname" => $user['fullname']);
            header("Location: index.php");
        }
    }

}
$smarty->display("login.html");



?>