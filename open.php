<?

if (isset($_SESSION['auth']) && $_SESSION['auth'] == true)
    header("Location: formular.php");

require "lib/init.php";

$content = $smarty->fetch("open.html");

$smarty->assign("page", "open_formular");
$smarty->assign("main_content", $content);
$smarty->display("main_template.html");
?>