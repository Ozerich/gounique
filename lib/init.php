<?php
session_start();

define("LIB_DIR", dirname(__FILE__) . DIRECTORY_SEPARATOR);
define("BASE_DIR", substr(LIB_DIR, 0, strrpos(substr(LIB_DIR, 0, -1), DIRECTORY_SEPARATOR) + 1));

require_once "config.php";

mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_DATABASE) or die(mysql_error());
mysql_query("SET NAMES UTF8");

require_once "smarty/libs/Smarty.class.php";

$smarty = new Smarty();
$smarty->template_dir = BASE_DIR . "templates/";
$smarty->compile_dir = BASE_DIR . "templates/compile/";

create_tables();


function create_tables()
{
    mysql_query("CREATE TABLE IF NOT EXISTS hotels (
      `id` INT(7) NOT NULL AUTO_INCREMENT,
      `hotelcode` VARCHAR(8) NOT NULL,
      `hotelname` VARCHAR(100) NOT NULL,
      `hotelstars` VARCHAR(3) NOT NULL,
      `roomcapacity` INT(1) NOT NULL,
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
}
