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
