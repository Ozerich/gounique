<?php
require_once "lib/init.php";
require_once "lib/search.php";
require_once "lib/Mailer.php";
require_once "lib/pdf.php";

if (!isset($_SESSION['auth']) || $_SESSION['auth'] == false)
    header("Location: login.php");

if (isset($_POST['add_submit'])) {
    $type = $_POST['type'];
    $p = $type == "agency" ? "a_" : "k_";
    mysql_query("INSERT INTO agency(type, datecreated, name,surname, address, plz, ort, city, website, sex, contactperson, email, phone, fax, provision, comment) VALUES (
    '" . $type . "', NOW(), '" . $_POST[$p . 'name'] . "', '" . $_POST[$p . 'surname'] . "', '" . $_POST[$p . 'address'] . "', '" . $_POST[$p . 'plz'] . "', '" . $_POST[$p . 'ort'] . "', '" . $_POST[$p . 'city'] .
                "', '" . $_POST[$p . 'website'] . "','" . $_POST[$p . 'sex'] . "', '" . $_POST[$p . 'contactperson'] . "', '" . $_POST[$p . 'email'] . "', '" . $_POST[$p . 'phone'] . "', '" .
                $_POST[$p . 'fax'] . "', '" . $_POST[$p . 'provision'] . "', '" . $_POST[$p . 'comment'] . "')") or die(mysql_error());

    header("Location: agency.php");
}
if (isset($_POST['edit_submit'])) {
    mysql_query("UPDATE agency SET name='" . $_POST['name'] . "',surname='" . $_POST['surname'] . "',address='" . $_POST['address'] .
                "',plz='" . $_POST['plz'] . "',ort='" . $_POST['ort'] . "',city='" . $_POST['city'] . "',website='" . $_POST['website'] .
                "',sex='" . $_POST['sex'] . "',contactperson='" . $_POST['contactperson'] . "',email='" . $_POST['email'] . "',phone='" . $_POST['phone'] .
                "',fax='" . $_POST['fax'] . "',provision='" . $_POST['provision'] . "',comment='" . $_POST['comment'] . "' WHERE id='".$_POST['agency_id']."'") or die(mysql_error());
    header("Location: agency.php");
}
if (isset($_GET['view'])) {
    $sql = mysql_query("SELECT * FROM agency WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
    $agency = mysql_fetch_assoc($sql);

    $sql = mysql_query("SELECT v_num, r_num FROM formulars WHERE k_num = '" . $_GET['id'] . "'") or die(mysql_error());

    while ($row = mysql_fetch_assoc($sql))
    {
        $date = date("d.M.y");
        $formulars[] = array("v_num" => $row['v_num'], "r_num" => $row['r_num'], "date" => $date);
    }
    $agency['formulars'] = $formulars;

    $smarty->assign("agency", $agency);

    $content = $smarty->fetch("agency-view.html");
}
else if (isset($_GET['delete'])) {
    mysql_query("DELETE FROM agency WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
    header("Location: agency.php");
}
else if (isset($_GET['add'])) {
    $content = $smarty->fetch("agency-add.html");
}
else if (isset($_GET['id'])) {
    $sql = mysql_query("SELECT * FROM agency WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
    $data = mysql_fetch_assoc($sql);
    $agency = $data;

    $smarty->assign("agency", $agency);
    $content = $smarty->fetch("agency-edit.html");
}
else
{
    $list = array();
    $sql = mysql_query("SELECT id,type, name, city, plz, phone FROM agency");
    while (($row = mysql_fetch_array($sql)))
        $list[] = $row;

    $smarty->assign("agency_list", $list);

    $content = $smarty->fetch("agencies.html");
}
$smarty->assign("JS_FILES", array("js/agency.js"));
$smarty->assign("page", "new_formular");
$smarty->assign("main_content", $content);
$smarty->display("main_template.html");

?>