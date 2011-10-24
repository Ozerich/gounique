<?
require "lib/init.php";

if(isset($_POST['login-submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    if($email == "admin@admin" && $password == "admin")
    {
        $_SESSION['auth'] = true;
        $_SESSION['user_email'] = $email;
        header("Location: index.php");
    }
}
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false)
    $smarty->display("login.html");
else
    header("Location: index.php");


?>