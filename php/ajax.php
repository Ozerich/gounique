<?php

require_once "init.php";

$mode = $_POST['mode'];
$result = "";

switch ($mode)
{
    case "hotelname":
        $_SESSION['hotelcode'] = $_POST['hotelcode'];
        $sql = mysql_query("SELECT hotelname FROM hotels WHERE hotelcode = '".$_SESSION['hotelcode']."'") or die(mysql_error());
        $result = @mysql_result($sql, 0);
        break;

    case "roomcapacity":
        $sql = mysql_query("SELECT DISTINCT roomcapacity FROM hotels WHERE hotelcode = '".$_SESSION['hotelcode']."'") or die(mysql_error());
        $result = array();
        while($data = mysql_fetch_row($sql))
        {
            $data = $data[0];
            if($data == 1)
                $result[] = array("value" => "1", "name" => "1 EZ");
            else if($data == 2)
                $result[] = array("value" => "2", "name" => "2 DZ");
        }
        $result = json_encode($result);
        break;

    case "roomtype":
        $_SESSION['roomcapacity'] = $_POST['roomcapacity'];
        $sql = mysql_query("SELECT DISTINCT roomtype FROM hotels WHERE hotelcode = '".$_SESSION['hotelcode']."' AND roomcapacity = '".
                           $_SESSION['roomcapacity']."'") or die(mysql_error());
        $result = array();
        while($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;
    
    case "service":
        $_SESSION['roomtype'] = $_POST['roomtype'];
        $sql = mysql_query("SELECT DISTINCT service FROM hotels WHERE hotelcode = '".$_SESSION['hotelcode']."' AND roomcapacity = '".
                           $_SESSION['roomcapacity']."' AND roomtype = '".$_SESSION['roomtype']."'") or die(mysql_error());
        $result = array();
        while($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "datestart":
        $_SESSION['service'] = $_POST['service'];
        $sql = mysql_query("SELECT DISTINCT datestart FROM hotels WHERE hotelcode = '".$_SESSION['hotelcode']."' AND roomcapacity = '".
                           $_SESSION['roomcapacity']."' AND roomtype = '".$_SESSION['roomtype']."' AND service = '".$_SESSION['service']."'") or die(mysql_error());
        $result = array();
        while($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "dateend":
        $_SESSION['datestart'] = $_POST['datestart'];
        $sql = mysql_query("SELECT DISTINCT dateend FROM hotels WHERE hotelcode = '".$_SESSION['hotelcode']."' AND roomcapacity = '".
                           $_SESSION['roomcapacity']."' AND roomtype = '".$_SESSION['roomtype']."' AND service = '".$_SESSION['service'].
                           "' AND datestart = '".$_SESSION['datestart']."'") or die(mysql_error());
        $result = array();
        while($data = mysql_fetch_row($sql))
            $result[] = $data[0];
        $result = json_encode($result);
        break;

    case "price":
        $_SESSION['dateend'] = $_POST['dateend'];
        $sql = mysql_query("SELECT DISTINCT price FROM hotels WHERE hotelcode = '".$_SESSION['hotelcode']."' AND roomcapacity = '".
                           $_SESSION['roomcapacity']."' AND roomtype = '".$_SESSION['roomtype']."' AND service = '".$_SESSION['service'].
                           "' AND datestart = '".$_SESSION['datestart']."' AND dateend = '".$_SESSION['dateend']."'") or die(mysql_error());
        $result = @mysql_result($sql, 0);
        break;

}

echo $result;

?>