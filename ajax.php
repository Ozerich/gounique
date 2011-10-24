<?php
error_reporting(E_ALL);

require_once "lib/init.php";
require_once "lib/pdf.php";
require_once "lib/Mailer.php";

$mode = $_GET['mode'];
$result = "";

function FixDate($date, $end = false)
{
    $day = substr($date, 0, 2);
    return mktime(0, 0, 0, substr($date, 2, 2), ($end ? $day - 1 : $day), substr($date, 4));
}

switch ($mode)
{
    case "hotelname":
        $sql = mysql_query("SELECT hotelname, hotelstars FROM hotels WHERE hotelcode = '" . $_POST['hotelcode'] . "'") or die(mysql_error());
        $data = mysql_fetch_assoc($sql);
        if ($data)
            $result = $data['hotelname'] . " " . $data['hotelstars'] . "*";
        break;

    case "roomcapacity":
        $sql = mysql_query("SELECT DISTINCT roomcapacity FROM hotels WHERE hotelcode = '" . $_POST['hotelcode'] . "'") or die(mysql_error());
        $result = array();
        while ($data = mysql_fetch_row($sql))
        {
            $data = $data[0];
            if ($data == 1)
                $result[] = array("value" => "1", "name" => "EZ");
            else if ($data == 2)
                $result[] = array("value" => "2", "name" => "DZ");
        }
        $result = json_encode($result);
        break;

    case "roomtype":
        $sql = mysql_query("SELECT DISTINCT roomtype FROM hotels WHERE hotelcode = '" . $_POST['hotelcode'] . "' AND roomcapacity = '" .
                           $_POST['roomcapacity'] . "'") or die(mysql_error());
        $result = array();
        while ($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "service":
        $sql = mysql_query("SELECT DISTINCT service FROM hotels WHERE hotelcode = '" . $_POST['hotelcode'] . "' AND roomcapacity = '" .
                           $_POST['roomcapacity'] . "' AND roomtype = '" . $_POST['roomtype'] . "'") or die(mysql_error());
        $result = array();
        while ($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "price":
        $datestart = FixDate($_POST['datestart']);
        $dateend = FixDate($_POST['dateend'], true);
        /*      $sql = mysql_query("SELECT DISTINCT SUM(price) as total FROM hotels WHERE hotelcode = '" . $_POST['hotelcode'] . "' AND roomcapacity = '" .
  $_POST['roomcapacity'] . "' AND roomtype = '" . $_POST['roomtype'] . "' AND service = '" . $_POST['service'] .
  "' AND date>=".$datestart." AND date<=".$dateend) or die(mysql_error());*/
        $result = 0;
        while ($datestart <= $dateend)
        {
            $sql = mysql_query("SELECT price FROM hotels WHERE hotelcode = '" . $_POST['hotelcode'] . "' AND roomcapacity = '" .
                               $_POST['roomcapacity'] . "' AND roomtype = '" . $_POST['roomtype'] . "' AND service = '" . $_POST['service'] .
                               "' AND date=" . $datestart) or die(mysql_error());
            $cur = @mysql_result($sql, 0);
            if (!$cur) {
                $result = 0;
                break;
            }
            $result += $cur;
            $day = getdate($datestart);
            $datestart = mktime(0, 0, 0, $day['mon'], $day['mday'] + 1, $day['year']);
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
