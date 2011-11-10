<?
require_once "lib/init.php";
require_once "lib/search.php";
require_once "lib/Mailer.php";
require_once "lib/pdf.php";

if (!isset($_SESSION['auth']) || $_SESSION['auth'] == false)
    header("Location: login.php");

$page = "dashboard";
if (isset($_GET['step']) && $_GET['step'] == 'result') {
    if (isset($_POST['submit'])) {
        $hotels = $manuels = array();
        if ($_POST['hotelcode'])
            foreach ($_POST['hotelcode'] as $ind => $code) {
                $hotels[] = array(
                    "hotelname" => $_POST['hotelname'][$ind],
                    "hotelcode" => $_POST['hotelcode'][$ind],
                    "datestart" => $_POST['datestart'][$ind],
                    "dateend" => $_POST['dateend'][$ind],
                    "dayscount" => $_POST['dayscount'][$ind],
                    "roomcapacity" => $_POST['roomcapacity'][$ind],
                    "roomtype" => $_POST['roomtype'][$ind],
                    "service" => $_POST['service'][$ind],
                    "transfer" => $_POST['transfer'][$ind],
                    "remark" => $_POST['remark'][$ind],
                    "price" => $_POST['price'][$ind],
                );
            }
        if ($_POST['manueltext'])
            foreach ($_POST['manueltext'] as $ind => $manuel)
            {
                $manuels[] = array(
                    "datestart" => $_POST['manueldatestart'][$ind],
                    "dateend" => $_POST['manueldateend'][$ind],
                    "dayscount" => $_POST['dayscount'][$ind],
                    "text" => $_POST['manueltext'][$ind],
                    "price" => $_POST['manuelprice'][$ind],
                );
            }
        $vorgangsnummer = $_POST['vorgangsnummer'];
        $sql_set = "type='" . $_POST['agent_kunden'] . "', k_num='" . $_POST['kundennummer'] . "', r_num='" . $_POST['rechnungsnummber'] .
                   "', provision='" . $_POST['provision'] . "', hotels='" . serialize($hotels) . "', manuels='" . serialize($manuels) .
                   "', flightplan='" . $_POST['flightplan'] . "', flightprice='" . $_POST['flightprice'] . "', personcount='" .
                   $_POST['personcount']."'";
        mysql_query("INSERT INTO formulars SET " . $sql_set . ", v_num='" . $vorgangsnummer . "' ON DUPLICATE KEY UPDATE " .
                    $sql_set) or die(mysql_error());

        header("Location: formular.php?step=result&vorgan=" . $_POST['vorgangsnummer']);
    }
    else {
        FillSmarty($_GET['vorgan']);
        $page = "result";
    }

}
else if (isset($_GET['step']) && $_GET['step'] == 'final') {
    if (isset($_POST['submit'])) {
        $id = $_GET['vorgan'];
        $persons = array();
        if ($_POST['person_name'])
            foreach ($_POST['person_name'] as $ind => $person)
            {
                $persons[] = array(
                    "name" => $_POST['person_name'][$ind],
                    "sex" => $_POST['sex'][$ind],
                );
            }
        mysql_query("UPDATE formulars SET comment='" . $_POST['bigcomment'] . "', persons='" . serialize($persons) . "', anzahlung='" . $_POST['anzahlung'] . "', abreisedatum='" .
                    $_POST['abreisedatum'] . "', address='" . $_POST['address'] .  "', zahlungsdatum = '".$_POST['zahlungsdatum']."' WHERE v_num='" . $id . "'") or die(mysql_error());
        WriteToPdf($id, 1);
        WriteToPdf($id, 2);
        WriteToPdf($id, 3);
        WriteToPdf($id, 4);
        header("Location: formular.php?step=final&vorgan=" . $_POST['vorgan']);
    }
    else
    {
        FillSmarty($_GET['vorgan']);
        $page = "final";
    }
}
else if (isset($_GET['step']) && $_GET['step'] == "start") {
    if (isset($_GET['vorgan'])) {
        FillSmarty($_GET['vorgan']);
        $page = "dashboard";
    }
}
else if (isset($_GET['step']) && $_GET['step'] == "finish") {
    if (isset($_POST['submit'])) {
        $Message = new Mailer();
        $Message->from =$_SESSION['user']['fullname'].'<'.$_SESSION['user']['email'].'>';
        $Message->subject = 'Subject';
        $Message->Attach('pdf/' . $_POST['vorgan'] . '_' . $_POST['stage'] . '.pdf', 'application/pdf');
        $Message->to = $_SESSION['user']['email'];
        $Message->Send();
        foreach ($_POST['email'] as $email)
        {
            $Message->to = $email;
            $Message->Send();
        }
        header("Location: formular.php?step=finish&vorgan=" . $_POST['vorgan']);
    }
    else
        header("Location: formular.php");
}
else if(!isset($_GET['step']))
{
    $smarty->assign("kundennummer",$_GET['k_num']);
    $sql = mysql_query("SELECT type, provision FROM agency WHERE id='".$_GET['k_num']."'") or die(mysql_error());
    $data = mysql_fetch_assoc($sql);
    $smarty->assign("type", $data['type']);
    if($data['type'] == "agency")
        $smarty->assign("provision", $data['provision']);
    $sql = mysql_query("SELECT value FROM config WHERE param='last_rnum'");
    $smarty->assign("rechnungsnummber",mysql_result($sql, 0, 0));
}

switch($page)
{
    case "dashboard":
        $content = $smarty->fetch("dashboard.html");
        $js = array("js/dashboard.js");
        break;
    case "result":
        $content = $smarty->fetch("result.html");
        $js = array("js/result.js");
        break;
    case "final":
        $content = $smarty->fetch("final.html");
        $js = array("js/final.js");
        break;
}

$smarty->assign("main_content", $content);
$smarty->assign("JS_FILES", $js);
$smarty->display("main_template.html");


?>