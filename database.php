<?php
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "usersdatabase";
    /** @var \mysqli $conn */
    $conn = "";

    try {
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    }catch(mysqli_sql_exception $e) {
        echo "You're not connected";
    }    
?>