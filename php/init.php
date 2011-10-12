<?php
session_start();

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "hotel");

mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die(mysql_error());
mysql_select_db(DB_DATABASE) or die(mysql_error());
mysql_query("SET NAMES UTF8");

create_tables();

function create_tables()
{
    mysql_query("CREATE TABLE IF NOT EXISTS hotels (
      `id` INT(7) NOT NULL,
      `hotelcode` VARCHAR(8) NOT NULL,
      `hotelname` VARCHAR(100) NOT NULL,
      `hotelstars` VARCHAR(3) NOT NULL,
      `roomcapacity` INT(1) NOT NULL,
      `roomtype` VARCHAR(20) NOT NULL,
      `service` VARCHAR(3) NOT NULL,
      `datestart` VARCHAR(10) NOT NULL,
      `dateend` VARCHAR(10) NOT NULL,
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
?>