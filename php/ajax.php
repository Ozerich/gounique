<?php
error_reporting(E_ALL);
require_once "init.php";
require_once "pdf.php";
require_once "Mailer.php";

$mode = $_POST['mode'];
$result = "";

switch ($mode)
{
    case "hotelname":
        $_SESSION['hotelcode'] = $_POST['hotelcode'];
        $sql = mysql_query("SELECT hotelname, hotelstars FROM hotels WHERE hotelcode = '" . $_SESSION['hotelcode'] . "'") or die(mysql_error());
        $data = mysql_fetch_assoc($sql);
        if ($data)
            $result = $data['hotelname'] . " " . $data['hotelstars'] . "*";
        break;

    case "roomcapacity":
        $sql = mysql_query("SELECT DISTINCT roomcapacity FROM hotels WHERE hotelcode = '" . $_SESSION['hotelcode'] . "'") or die(mysql_error());
        $result = array();
        while ($data = mysql_fetch_row($sql))
        {
            $data = $data[0];
            if ($data == 1)
                $result[] = array("value" => "1", "name" => "1 EZ");
            else if ($data == 2)
                $result[] = array("value" => "2", "name" => "2 DZ");
        }
        $result = json_encode($result);
        break;

    case "roomtype":
        $_SESSION['roomcapacity'] = $_POST['roomcapacity'];
        $sql = mysql_query("SELECT DISTINCT roomtype FROM hotels WHERE hotelcode = '" . $_SESSION['hotelcode'] . "' AND roomcapacity = '" .
                           $_SESSION['roomcapacity'] . "'") or die(mysql_error());
        $result = array();
        while ($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "service":
        $_SESSION['roomtype'] = $_POST['roomtype'];
        $sql = mysql_query("SELECT DISTINCT service FROM hotels WHERE hotelcode = '" . $_SESSION['hotelcode'] . "' AND roomcapacity = '" .
                           $_SESSION['roomcapacity'] . "' AND roomtype = '" . $_SESSION['roomtype'] . "'") or die(mysql_error());
        $result = array();
        while ($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "datestart":
        $_SESSION['service'] = $_POST['service'];
        $sql = mysql_query("SELECT DISTINCT datestart FROM hotels WHERE hotelcode = '" . $_SESSION['hotelcode'] . "' AND roomcapacity = '" .
                           $_SESSION['roomcapacity'] . "' AND roomtype = '" . $_SESSION['roomtype'] . "' AND service = '" . $_SESSION['service'] . "'") or die(mysql_error());
        $result = array();
        while ($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "dateend":
        $_SESSION['datestart'] = $_POST['datestart'];
        $sql = mysql_query("SELECT DISTINCT dateend FROM hotels WHERE hotelcode = '" . $_SESSION['hotelcode'] . "' AND roomcapacity = '" .
                           $_SESSION['roomcapacity'] . "' AND roomtype = '" . $_SESSION['roomtype'] . "' AND service = '" . $_SESSION['service'] .
                           "' AND datestart = '" . $_SESSION['datestart'] . "'") or die(mysql_error());
        $result = array();
        while ($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "price":
        if (isset($_POST['dateend'])) {
            $_SESSION['datestart'] = $_POST['datestart'];
            $_SESSION['dateend'] = $_POST['dateend'];
            $sql = mysql_query("SELECT COUNT(*) FROM hotels WHERE hotelcode = '" . $_SESSION['hotelcode'] . "' AND roomcapacity = '" .
                               $_SESSION['roomcapacity'] . "' AND roomtype = '" . $_SESSION['roomtype'] . "' AND service = '" . $_SESSION['service'] .
                               "' AND datestart = '" . $_SESSION['datestart'] . "' AND dateend = '" . $_SESSION['dateend'] . "'") or die(mysql_error());
            $result = mysql_result($sql, 0);
            break;
        }
        $_SESSION['transfer'] = $_POST['transfer'];
        $sql = mysql_query("SELECT DISTINCT price FROM hotels WHERE hotelcode = '" . $_SESSION['hotelcode'] . "' AND roomcapacity = '" .
                           $_SESSION['roomcapacity'] . "' AND roomtype = '" . $_SESSION['roomtype'] . "' AND service = '" . $_SESSION['service'] .
                           "' AND datestart = '" . $_SESSION['datestart'] . "' AND dateend = '" . $_SESSION['dateend'] . "'") or die(mysql_error());
        $result = @mysql_result($sql, 0);
        if ($_SESSION['transfer'] != "no") {
            $sql = mysql_query("SELECT cost_" . $_SESSION['transfer'] . " FROM transfers WHERE hotelcode = '" . $_SESSION['hotelcode'] . "'");
            $result += @mysql_result($sql, 0);
        }
        break;

    case "pdf":
        $persons = array();
        foreach ($_POST['sex'] as $ind => $sex)
            $persons[] = array("sex" => $sex, "name" => $_POST['person_name'][$ind]);
        $tours = array();
        foreach ($_POST['hoteldate'] as $ind => $hoteldate)
            $tours[] = array("date" => $hoteldate, "content" => $_POST['hotelcontent'][$ind]);
        WriteToPdf($_POST['vorgansnummer'], $persons, $tours, $_POST['flightplan'], $_POST['priceperson']);
        if (isset($_POST['sendmail'])) {
            $Message = new Mailer();
            foreach ($_POST['email'] as $email)
            {
                $Message->from = 'Ot Menya <ot@menya.com>';
                $Message->to = $email;
                $Message->subject = $_POST['subject'];
                $Message->Attach('result.pdf', 'text/pdf');
                $Message->Send();
            }
        }
        $result = "OK";
}

echo $result;

?>
