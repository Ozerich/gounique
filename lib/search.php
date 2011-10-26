<?php

function GetCapacity($hotel_code, $roomtype)
{
    $sql = mysql_query("SELECT DISTINCT roomcapacity FROM hotels WHERE hotelcode = '" . $hotel_code . "' AND roomtype='" . $roomtype . "'") or die(mysql_error());
    $result = array();
    while ($data = mysql_fetch_row($sql))
        $result[] = array("value" => $data[0], "name" => $data[0]);
    return $result;
}

function GetRoomtype($hotel_code)
{
    $sql = mysql_query("SELECT DISTINCT roomtype FROM hotels WHERE hotelcode = '" . $hotel_code . "'") or die(mysql_error());
    $result = array();
    while ($data = mysql_fetch_row($sql))
        $result[] = array("value" => $data[0], "name" => $data[0]);
    return $result;
}

function GetService($hotel_code, $capacity, $roomtype)
{
    $sql = mysql_query("SELECT DISTINCT service FROM hotels WHERE hotelcode = '" . $hotel_code . "' AND roomcapacity = '" .
                       $capacity . "' AND roomtype = '" . $roomtype . "'") or die(mysql_error());
    $result = array();
    while ($data = mysql_fetch_row($sql))
        $result[] = array("value" => $data[0], "name" => $data[0]);
    return $result;
}


function FillSmarty($id)
{
    global $smarty;

    $sql = mysql_query("SELECT * FROM formulars WHERE v_num ='" . $id . "'") or die(mysql_error());
    $data = mysql_fetch_assoc($sql);
    $price = 0;
    $hotels = unserialize($data['hotels']);
    if (!empty($hotels))
        foreach ($hotels as $hotel)
            $price += $hotel['price'];

    foreach ($hotels as &$hotel)
    {
        $hotel['allcapacity'] = GetCapacity($hotel['hotelcode'], $hotel['roomtype']);
        foreach ($hotel['allcapacity'] as &$item)
            $item['current'] = $item['value'] == $hotel['roomcapacity'] ? 1 : 0;
        $hotel['allroomtype'] = GetRoomtype($hotel['hotelcode']);
        foreach ($hotel['allroomtype'] as &$item)
            $item['current'] = $item['value'] == $hotel['roomtype'] ? 1 : 0;
        $hotel['allservice'] = GetService($hotel['hotelcode'], $hotel['roomcapacity'], $hotel['roomtype']);
        foreach ($hotel['allservice'] as &$item)
            $item['current'] = $item['value'] == $hotel['service'] ? 1 : 0;
    }

    $smarty->assign("hotels", $hotels);

    $manuel_price = 0;

    $manuels = unserialize($data['manuels']);
    if (!empty($manuels))
        foreach ($manuels as $manuel)
            $manuel_price += $manuel['price'];

    $smarty->assign("manuels", $manuels);

    $hotel_price = $price;
    $price += $data['flightprice'];

    $pricetpl = array();
    $pricetpl['person'] = $price / $data['personcount'];
    $pricetpl['brutto'] = $price + $manuel_price;
    $pricetpl['netto'] = round($pricetpl['brutto'] / 1.19, 2);
    $pricetpl['provision'] = round($hotel_price * $data['provision'] / 100, 2);
    $pricetpl['percent'] = round($pricetpl['provision'] / 1.19 * 0.19, 2);
    $pricetpl['anzahlung'] = $data['anzahlung'];
    $pricetpl['anzahlung_value'] = round($pricetpl['brutto'] / 100 * $data['anzahlung']);
    $smarty->assign("price", $pricetpl);

    $smarty->assign("type", $data['type']);
    $smarty->assign("address", $data['address']);

    $smarty->assign("flightplan", array(
                                       "content" => $data['flightplan'],
                                       "price" => $data['flightprice'],
                                  ));

    $smarty->assign("personcount", $data['personcount']);
    $smarty->assign("kundennummer", $data['k_num']);
    $smarty->assign("rechnungsnummber", $data['r_num']);
    $smarty->assign("vorgansnummer", $id);

    $smarty->assign("provision", $data['provision']);

    $smarty->assign("abreisedatum", $data['abreisedatum']);
    $smarty->assign("zahlungsdatum", $data['zahlungsdatum']);

    $date_a = mktime(0, 0, 0, substr($data['abreisedatum'], 2, 2), substr($data['abreisedatum'], 0, 2), substr($data['abreisedatum'], 4));
    $date_z = mktime(0, 0, 0, substr($data['zahlungsdatum'], 2, 2), substr($data['zahlungsdatum'], 0, 2), substr($data['zahlungsdatum'], 4));
    $smarty->assign("print_under", (($date_a - $date_z) >= 432000) ? 1 : 0);

    $smarty->assign("persons", unserialize($data['persons']));

    $smarty->assign("mode", "edit");
    $smarty->assign("stage", $data['stage']);
    $smarty->assign("bigcomment", $data['comment']);

    $smarty->assign("today", date("d.m.Y"));

    $smarty->assign("id", $id);
}

?>