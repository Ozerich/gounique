<?
require "lib/init.php";

if(!isset($_SESSION['auth']) || $_SESSION['auth'] == false)
    header("Location: login.php");

if (!isset($_POST['fertig']))
    $smarty->display("dashboard.html");
else
{
    $price = 0;
    $hotels = array();
    foreach ($_POST['hotelcode'] as $ind => $code) {
        $hotels[] = array(
            "hotelname" => $_POST['hotelname'][$ind],
            "datestart" => $_POST['datestart'][$ind],
            "dateend" => $_POST['dateend'][$ind],
            "dayscount" => $_POST['dayscount'][$ind],
            "roomcapacity" => $_POST['roomcapacity'][$ind],
            "roomtype" => $_POST['roomtype'][$ind],
            "service" => $_POST['service'][$ind],
            "transfer" => $_POST['transfer'][$ind],
            "remark" => $_POST['remark'][$ind]
        );
        $price += $_POST['price'][$ind];
    }
    $smarty->assign("hotels", $hotels);


    $manuels = array();
    foreach ($_POST['manueltext'] as $ind => $manuel)
    {
        $manuels[] = array(
            "datestart" => $_POST['manueldatestart'][$ind],
            "dateend" => $_POST['dateend'][$ind],
            "text" => $_POST['manueltext'][$ind],
        );
        $price += $_POST['manuelprice'][$ind];
    }
    $smarty->assign("manuels", $manuels);

    $hotel_price = $price;
    $price += $_POST['flightprice'];

    $pricetpl = array();
    $pricetpl['person'] = $price / $_POST['personcount'];
    $pricetpl['brutto'] = $price;
    $pricetpl['netto'] = round($price / 1.19, 2);
    $pricetpl['provision'] = round($hotel_price * 0.2, 2);
    $pricetpl['percent'] = round($price / 1.19 * 0.19, 2);
    $smarty->assign("price", $pricetpl);

    $smarty->assign("flightplan", array(
                                       "content" => $_POST['flightplan'],
                                       "price" => $_POST['flightprice'],
                                  ));

    $smarty->display("result.html");
}

?>

