<?php

// define("DB_HOST", "mysql.hostinger.mx");
// define("DB_USER", "u578567914_admin");
// define("DB_PASSWORD", "Galaviz14");
// define("DB_DATABASE", "u578567914_chan");

define("DB_HOST", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "ely");


//configuracion del entorno de desarrollo
define("SYS_ENTORNO", false);
// define("DB_HOST", "127.0.0.1");
// define("DB_USER", "root");
// define("DB_PASSWORD", "");
// define("DB_DATABASE", "changarro");

if(SYS_ENTORNO){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    error_reporting(0);
}
?>