<?php

// define("DB_HOST", "localhost");
// define("DB_USER", "flyrunco_royal");
// define("DB_PASSWORD", "kN!qq@K+*Wz4");
// define("DB_DATABASE", "flyrunco_royal");

define("DB_HOST", "127.0.0.1");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "royal_prestige");

//configuracion del entorno de desarrollo
define("SYS_ENTORNO", true);

if(SYS_ENTORNO){
    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    error_reporting(0);
}
?>