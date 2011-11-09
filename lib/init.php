<?php
session_start();

ini_set('magic_quotes_runtime', false);
ini_set('magic_quotes_gpc', false);

define("LIB_DIR", dirname(__FILE__) . DIRECTORY_SEPARATOR);
define("BASE_DIR", substr(LIB_DIR, 0, strrpos(substr(LIB_DIR, 0, -1), DIRECTORY_SEPARATOR) + 1));

require_once "config.php";
require_once "users.php";

mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_DATABASE) or die(mysql_error());
mysql_query("SET NAMES UTF8");

require_once LIB_DIR . "smarty/libs/Smarty.class.php";

$smarty = new Smarty();
$smarty->template_dir = BASE_DIR . "templates/";
$smarty->compile_dir = BASE_DIR . "templates/compile/";

$smarty->assign("user", array("email" => $_SESSION['user']['email'], "fullname" => $_SESSION['user']['fullname']));

create_tables();


function create_tables()
{
    mysql_query("CREATE TABLE IF NOT EXISTS hotels (
      `id` INT(7) NOT NULL AUTO_INCREMENT,
      `hotelcode` VARCHAR(8) NOT NULL,
      `hotelname` VARCHAR(100) NOT NULL,
      `hotelstars` VARCHAR(3) NOT NULL,
      `roomcapacity` VARCHAR(10) NOT NULL,
      `roomtype` VARCHAR(20) NOT NULL,
      `service` VARCHAR(3) NOT NULL,
      `date` VARCHAR(10) NOT NULL,
      `price` INT NOT NULL,
      PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8") or die(mysql_error());

    mysql_query("CREATE TABLE IF NOT EXISTS transfers (
      `id` INT(7) NOT NULL AUTO_INCREMENT,
      `hotelcode` VARCHAR(8) NOT NULL,
      `cost_in` INT NOT NULL,
      `cost_out` INT NOT NULL,
      `cost_rt` INT NOT NULL,
      PRIMARY KEY (`id`)
    )ENGINE MyISAM DEFAULT CHARSET=utf8") or die(mysql_error());

    mysql_query("CREATE TABLE IF NOT EXISTS formulars (
        `v_num` VARCHAR(10) NOT NULL,
        `stage` INT(1) DEFAULT 1 NOT NULL,
        `type` CHAR NOT NULL,
        `k_num` VARCHAR(10) NOT NULL,
        `r_num` VARCHAR(10) NOT NULL,
        `provision` INT(3) NOT NULL,
        `personcount` INT(3) NOT NULL,
        `persons` TEXT NOT NULL,
        `hotels` TEXT NOT NULL,
        `manuels` TEXT NOT NULL,
        `flightplan` TEXT NOT NULL,
        `flightprice` TEXT NOT NULL,
        `anzahlung` INT NOT NULL,
        `abreisedatum` VARCHAR(8) NOT NULL,
        `zahlungsdatum` VARCHAR(8) NOT NULL,
        `comment` TEXT NOT NULL,
        `address` TEXT NOT NULL,
        PRIMARY KEY (`v_num`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8") or die(mysql_error());
}
