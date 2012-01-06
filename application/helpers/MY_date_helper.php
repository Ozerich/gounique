<?php

function mysqldatetime_to_timestamp($datetime = "")
{
    $l = strlen($datetime);

    if (!($l == 10 || $l == 19))
        return false;

    $date = $datetime;
    $hours = 0;
    $minutes = 0;
    $seconds = 0;

    if ($l == 19) {
        list($date, $time) = explode(" ", $datetime);
        list($hours, $minutes, $seconds) = explode(":", $time);
    }

    list($year, $month, $day) = explode("-", $date);

    return mktime($hours, $minutes, $seconds, $month, $day, $year);
}

function mysqldate_to_timestamp($date = "")
{
    list($year, $month, $day) = explode("-", $date);
    return mktime(0,0,0,$month, $day, $year);
}

function time_to_mysqltime($time = "")
{
    $time = getdate($time);

    $h = $time['hours'] < 10 ? '0'.$time['hours'] : $time['hours'];
    $m = $time['minutes'] < 10 ? '0'.$time['minutes'] : $time['minutes'];
    $s = $time['seconds'] < 10 ? '0'.$time['seconds'] : $time['seconds'];

    return $h.':'.$m.':'.$s;
}

function time_to_mysqldate($time = "")
{
    $date = getdate($time);

    $mon = $date['mon'] < 10 ? '0'.$date['mon'] : $date['mon'];
    $day = $date['mday'] < 10 ? '0'.$date['mday'] : $date['mday'];

    return $date['year']."-".$mon."-".$day;
}

function time_to_mysqldatetime($time = "")
{
    return time_to_mysqldate($time)." ".time_to_mysqltime($time);
}

function inputdate_to_mysqldate($date = "")
{
    $time = mktime(0,0,0,substr($date, 2, 2), substr($date,0,2), substr($date, 4));

    return time_to_mysqldate($time);
}

?>