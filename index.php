<?
require_once "lib/init.php";
require_once "lib/search.php";
require_once "lib/Mailer.php";
require_once "lib/pdf.php";

if (!isset($_SESSION['auth']) || $_SESSION['auth'] == false)
    header("Location: login.php");

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
                   $_POST['personcount'] . "'";
        mysql_query("INSERT INTO formulars SET " . $sql_set . ", v_num='" . $vorgangsnummer . "' ON DUPLICATE KEY UPDATE " .
                    $sql_set) or die(mysql_error());

        header("Location: index.php?step=result&vorgan=" . $_POST['vorgangsnummer']);
    }
    else {
        FillSmarty($_GET['vorgan']);
        $smarty->display("result.html");
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
                    $_POST['abreisedatum'] . "', address='" . $_POST['address'] . "' WHERE v_num='" . $id . "'") or die(mysql_error());
        WriteToPdf($id, 1);
        WriteToPdf($id, 2);
        WriteToPdf($id, 3);
        header("Location: index.php?step=final&vorgan=" . $_POST['vorgan']);
    }
    else
    {
        FillSmarty($_GET['vorgan']);
        $smarty->display("final.html");
    }
}
else if (isset($_GET['step']) && $_GET['step'] == "start") {
    if (isset($_GET['vorgan'])) {
        FillSmarty($_GET['vorgan']);
        $smarty->display("dashboard.html");
    }
}
else if (isset($_GET['step']) && $_GET['step'] == "finish") {
    if (isset($_POST['submit'])) {
        $Message = new Mailer();
        $Message->from = 'GoUnique';
        $Message->subject = 'Subject';
        $Message->Attach('pdf/' . $_POST['vorgan'] . '_' . $_POST['stage'] . '.pdf', 'text/pdf');
        $Message->to = $_SESSION['user']['email'];
        $Message->Send();
        foreach ($_POST['email'] as $email)
        {
            $Message->to = $email;
            $Message->Send();
        }
        header("Location: index.php?step=finish&vorgan=" . $_POST['vorgan']);
    }
    else
        header("Location: index.php");
}
else
    $smarty->display("dashboard.html");

?>