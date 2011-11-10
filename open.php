<?

if (isset($_SESSION['auth']) && $_SESSION['auth'] == true)
    header("Location: formular.php");

require "lib/init.php";

$smarty->display("open.html");
?>