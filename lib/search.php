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
    if (!empty($hotels))
        foreach ($hotels as &$hotel)
        {
            $hotel['allcapacity'] = GetCapacity($hotel['hotelcode'], $hotel['roomtype']);
            $hotel['datestartformatted'] = substr($hotel['datestart'], 0, 2) . '.' . substr($hotel['datestart'], 2, 2) . '.' . substr($hotel['datestart'], 4);
            $hotel['dateendformatted'] = substr($hotel['dateend'], 0, 2) . '.' . substr($hotel['dateend'], 2, 2) . '.' . substr($hotel['dateend'], 4);
            if (!empty($hotel['allcapacity']))
                foreach ($hotel['allcapacity'] as &$item)
                    $item['current'] = $item['value'] == $hotel['roomcapacity'] ? 1 : 0;
            $hotel['allroomtype'] = GetRoomtype($hotel['hotelcode']);
            if (!empty($hotel['allroomtype']))
                foreach ($hotel['allroomtype'] as &$item)
                    $item['current'] = $item['value'] == $hotel['roomtype'] ? 1 : 0;
            $hotel['allservice'] = GetService($hotel['hotelcode'], $hotel['roomcapacity'], $hotel['roomtype']);
            if (!empty($hotel['allservice']))
                foreach ($hotel['allservice'] as &$item)
                    $item['current'] = $item['value'] == $hotel['service'] ? 1 : 0;

        }
    $smarty->assign("hotels", $hotels);

    $manuel_price = 0;

    $manuels = unserialize($data['manuels']);
    if (!empty($manuels)) {
        foreach ($manuels as &$manuel) {
            $manuel_price += $manuel['price'];
            $manuel['dateendformatted'] = substr($manuel['dateend'], 0, 2) . '.' . substr($manuel['dateend'], 2, 2) . '.' . substr($manuel['dateend'], 4);
            $manuel['datestartformatted'] = substr($manuel['datestart'], 0, 2) . '.' . substr($manuel['datestart'], 2, 2) . '.' . substr($manuel['datestart'], 4);
        }
    }
    $smarty->assign("manuels", $manuels);

    $hotel_price = $price;
    $price += $data['flightprice'];
    $price = $price * $data['personcount'];
    $pricetpl = array();

    $pricetpl['brutto'] = $price + $manuel_price;
    $pricetpl['person'] = $data['personcount'] == 0 ? 0 : $pricetpl['brutto'] / $data['personcount'];
    $pricetpl['netto'] = round($pricetpl['brutto'] / 1.19, 2);
    $pricetpl['provision'] = round($pricetpl['brutto'] * $data['provision'] / 100, 2);
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

    $smarty->assign("abreisedatum", substr($smarty->tpl_vars['abreisedatum'],0,2).".".substr($smarty->tpl_vars['abreisedatum'],2,2).".".substr($smarty->tpl_vars['abreisedatum'],4));
    $smarty->assign("zahlungsdatum", substr($smarty->tpl_vars['zahlungsdatum'],0,2).".".substr($smarty->tpl_vars['zahlungsdatum'],2,2).".".substr($smarty->tpl_vars['zahlungsdatum'],4));

    $date_a = mktime(0, 0, 0, substr($data['abreisedatum'], 2, 2), substr($data['abreisedatum'], 0, 2), substr($data['abreisedatum'], 4));
    $date_z = mktime(0, 0, 0, substr($data['zahlungsdatum'], 2, 2), substr($data['zahlungsdatum'], 0, 2), substr($data['zahlungsdatum'], 4));
    $smarty->assign("print_under", (($date_a - $date_z) >= 432000) ? 1 : 0);

    $smarty->assign("persons", unserialize($data['persons']));

    $smarty->assign("mode", "edit");
    $smarty->assign("stage", $data['stage']);
    $smarty->assign("bigcomment", $data['comment']);

    $smarty->assign("today", date("d.m.Y"));

    $smarty->assign("id", $id);


    $agency = mysql_query("SELECT * FROM agency WHERE id=".$data['k_num']) or die(mysql_error());
    $agency = mysql_fetch_assoc($agency);
    $smarty->assign("agency", $agency);

}

?>