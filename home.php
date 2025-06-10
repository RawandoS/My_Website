<?php
    session_start();
    if (!isset($_SESSION['isLoggedIn'])){
        header('Location: login.php');
        exit();
    }
    if (isset($_POST["logout"])){
        session_destroy();
        header("Location: index.php");
    }
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
            <a href="glass.php" target="_self">
                <button>Glass Maker</button>
            </a>
            <h2>HUB</h2>
            <h3 id="account">
                <?php
                    echo "<p>{$_SESSION['username']}</p>"
                ?>
                <a href="accountPage.php">
                    <!-- <img src=".\images\userIcon" width="12.5%"> -->
                </a>
            </h3>
        </header>
        <center><div id="mainHub">
            <?php
                echo "<h2>Hello {$_SESSION['username']}<br></h2>";
            ?>
            <div id="gridB">
                
            </div>
        </div></center>
        <footer>
            <form action="index.php" method="post">
                <input type="submit" name="logout" value="Logout">
            </form>
        </footer>
    </body>
</html>