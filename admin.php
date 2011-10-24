<?php

require_once "lib/init.php";

function FixDate($date)
{
    $date = explode(".", $date);
    return mktime(0, 0, 0, $date[1], $date[0], $date[2]);
}

function FileGetExtension($filename)
{
    return strtolower(substr($filename, strrpos($filename, ".") + 1));
}

function FixService($input)
{
    if($input == "F")return "ÜF";
    else if($input == "A") return "UAI";
    else if($input == "H") return "HP";
    else if($input == "V") return "VP";
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

    mysql_query("TRUNCATE TABLE hotels") or die(mysql_error());

    while(($data = fgetcsv($f, 1000, ";")) !== false)
    {
        mysql_query("INSERT INTO hotels(hotelcode, hotelname, hotelstars, roomcapacity, roomtype, service, date, price)
            VALUES ('".$data[3]."','".$data[7]."','".$data[8]."','".$data[14]."','".$data[10]."','".FixService($data[11])."','".FixDate($data[0])."','".$data[5]."')")
                or die(mysql_error());
    }

    mysql_query("TRUNCATE TABLE transfers") or die(mysql_error());
    //for transfers
        $sql = mysql_query("SELECT DISTINCT hotelcode FROM hotels") or die(mysql_error());
        $data = mysql_fetch_assoc($sql);

        while($data){
            mysql_query("INSERT INTO transfers(hotelcode, cost_in, cost_out, cost_rt) 
            VALUES ('".$data['hotelcode']."', 0, 0, 0)") or die(mysql_error());
            $data = mysql_fetch_assoc($sql);
          }

    echo "Файл загружен в базу";

    fclose($f);
}
?>