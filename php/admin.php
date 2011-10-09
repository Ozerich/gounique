<?php

require_once "init.php";

if (isset($_POST['submit'])) {
    $hotel_file = $_FILES['hotel_file'];
    $f = fopen($hotel_file['tmp_name'], "r+");
    if($f === false)
    {
        echo "Error to open file";
        exit();
    }

    mysql_query("TRUNCATE TABLE hotels");

    while(($data = fgetcsv($f, 1000, ";")) !== false)
    {
        mysql_query("INSERT INTO hotels(id, hotelcode, hotelname, hotelstars, roomcapacity, roomtype, service, datebegin, dateend, price)
            VALUES ('".$data[0]."','".$data[11]."','".$data[17]."','".$data[19]."','".$data[14]."','".$data[26]."','".$data[23]."','".$data[8]."','".$data[9]."','".$data[16]."')")
                or die(mysql_error());
    }

    echo "Файл загружен в базу";

    fclose($f);
}
?>