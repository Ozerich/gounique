<?php
require_once "lib/init.php";
require_once "lib/search.php";
require_once "lib/Mailer.php";
require_once "lib/pdf.php";

if (!isset($_SESSION['auth']) || $_SESSION['auth'] == false)
    header("Location: login.php");

if(isset($_POST['add_submit']))
{
    $type = $_POST['type'] == 1 ? "agency" : "kunde";
    mysql_query("INSERT INTO agency(type, datecreated, name, address, zipcode, city, website, contactperson, email, phone, fax, provision, comment) VALUES (
    '".$type."', NOW(), '".$_POST['name']."', '".$_POST['address']."', '".$_POST['zipcode']."', '".$_POST['city']."', '".$_POST['website']."', '".$_POST['contactperson']."', '".
                $_POST['email']."', '".$_POST['phone']."', '".$_POST['fax']."', '".$_POST['provision']."', '".$_POST['comment']."')") or die(mysql_error());

    header("Location: agency.php");
}
if(isset($_GET['delete']))
{
    mysql_query("DELETE FROM agency WHERE id='".$_GET['id']."'") or die(mysql_error());
    header("Location: agency.php");
}
if(isset($_GET['edit']))
{
    mysql_query("UPDATE agency SET ".$_POST['param']."='".$_POST['value']."' WHERE id='".$_GET['id']."'") or die(mysql_error());
    echo $_POST['value'];
    exit();
}
if (isset($_GET['add'])) {
    $content = $smarty->fetch("agency-add.html");
}
else if(isset($_GET['id']))
{
    $sql = mysql_query("SELECT * FROM agency WHERE id='".$_GET['id']."'") or die(mysql_error());
    $data = mysql_fetch_assoc($sql);
    $agency = $data;

    $sql = mysql_query("SELECT v_num, r_num FROM formulars WHERE k_num = '".$_GET['id']."'") or die(mysql_error());

    while($row = mysql_fetch_assoc($sql))
    {
        $date = date("d.M.y");
        $formulars[] = array("v_num" => $row['v_num'], "r_num"=> $row['r_num'], "date" => $date);
    }
    $agency['formulars'] = $formulars;
    $smarty->assign("agency", $agency);

    $content = $smarty->fetch("agency-item.html");
}
else
{
    $list = array();
    $sql = mysql_query("SELECT id, name, city, phone FROM agency");
    while (($row = mysql_fetch_array($sql)))
        $list[] = $row;

    $smarty->assign("agency_list", $list);
    $content = $smarty->fetch("agencies.html");
}
$smarty->assign("JS_FILES", array("js/agency.js"));
$smarty->assign("main_content", $content);
$smarty->display("main_template.html");

?>