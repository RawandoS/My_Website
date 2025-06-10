<?php
    session_start();
    if (!isset($_SESSION['isLoggedIn'])){
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Account Page</title>
    </head>
    <body>
        
    </body>
</html>