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
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header >
            <?php
                echo strtoupper("<h1>
                    {$_SESSION['username']}
                </h1>");
            ?>
        </header>
        <nav>

        </nav>
        <footer>

        </footer>
    </body>
</html>