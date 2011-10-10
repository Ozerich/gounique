<?php

require_once "init.php";

function FixDate($date)
{
    $date = explode("-", $date);
    return $date[2].".".$date[1].".".$date[0];
}

function FileGetExtension($filename)
{
    return strtolower(substr($filename, strrpos($filename, ".") + 1));
}

if (isset($_POST['submit'])) {
    $hotel_file = $_FILES['hotel_file'];
    if(FileGetExtension($hotel_file['name']) != "csv")
    {
        echo "No CSV file";
        exit();
    }
    $f = fopen($hotel_file['tmp_name'], "r+");
    if($f === false)
    {
        echo "Error to open file";
        exit();
    }
    $data = fgetcsv($f, 1000, ";");
    if(!$data)
    {
        echo "CSV file corrupted";
        fclose($f);
        exit();
    }

    mysql_query("TRUNCATE TABLE hotels");

    while(($data = fgetcsv($f, 1000, ";")) !== false)
    {
        mysql_query("INSERT INTO hotels(id, hotelcode, hotelname, hotelstars, roomcapacity, roomtype, service, datestart, dateend, price)
            VALUES ('".$data[0]."','".$data[11]."','".$data[17]."','".$data[19]."','".$data[14]."','".$data[26]."','".$data[23]."','".FixDate($data[8])."','".FixDate($data[9])."','".$data[16]."')")
                or die(mysql_error());
    }

    echo "Файл загружен в базу";

    fclose($f);
}
?>