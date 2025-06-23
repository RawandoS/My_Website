<?php

if ($_SERVER['SERVER_NAME'] == "localhost"){
    define("DBANME","usersdatabase");
    define("DBHOST","localhost");
    define("DBUSER","root");
    define("DBPASS","");
    define("DBDRIVER","");

    define("ROOT","http://localhost/public");
}else{
    define("DBANME","usersdatabase");
    define("DBHOST","localhost");
    define("DBUSER","root");
    define("DBPASS","");
    define("DBDRIVER","");
    
    //define(constant_name: "ROOT","https://www.yourwebsite.com");
}

define("APP_NAME","My_Website");

/**
 * if true error are shown, if false errors aren't shown
 */
define("DEBUG",true);