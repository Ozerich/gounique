<?php
error_reporting(E_ALL);

require_once "lib/init.php";
require_once "lib/pdf.php";
require_once "lib/Mailer.php";
require_once "lib/search.php";

$mode = $_GET['mode'];
$result = "";

function FixDate($date, $end = false)
{
    $day = substr($date, 0, 2);
    return mktime(0, 0, 0, substr($date, 2, 2), ($end ? $day - 1 : $day), substr($date, 4));
}


switch ($mode)
{
    case "stage":
        mysql_query("UPDATE formulars SET stage='".$_POST['stage']."' WHERE v_num='".$_POST['vorgan']."'") or die(mysql_error());
        break;

    case "hotelname":
        $sql = mysql_query("SELECT hotelname, hotelstars FROM hotels WHERE hotelcode = '" . $_POST['hotelcode'] . "'") or die(mysql_error());
        $data = mysql_fetch_assoc($sql);
        if ($data)
            $result = $data['hotelname'] . " " . $data['hotelstars'] . "*";
        break;

    case "roomcapacity":
        $result = json_encode(GetCapacity($_POST['hotelcode'], $_POST['roomtype']));
        break;

    case "roomtype":
        $result = json_encode(GetRoomtype($_POST['hotelcode']));
        break;

    case "service":

        $result = json_encode(GetService($_POST['hotelcode'], $_POST['roomcapacity'], $_POST['roomtype']));
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
}

echo $result;

?>
