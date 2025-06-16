<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Home Page</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header>
            <div class="hub">
                <h2>HOME PAGE</h2>
            </div>
            <nav class="navbar">
                <div class="leftNav">
                    <a href="login.php" target="_self">
                        <button>Login</button>
                    </a>
                </div>
                <div class="rightNav">
                    <a href="register.php" target="_self">
                        <button>Register</button>
                    </a>
                </div>
            </nav>
        </header>
        <center><h1>Welcome</h1></center>
    </body>
</html>