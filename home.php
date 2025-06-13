<?php
    session_start();
    if (!isset($_SESSION['isLoggedIn'])) {
        header('Location: login.php');
        exit();
    }
    if (isset($_POST["logout"])){
        $_SESSION['username'] = "";
        $_SESSION['isLoggedIn'] = false;
        session_destroy();
        header('Location: index.php');
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
            <div class="hub">
                <h2>HUB</h2>
            </div>
            <nav class="navbar">
                <div class="leftNav">
                    <a href="glass.php" target="_self">
                        <button>Glass Maker</button>
                    </a>
                </div>
                <div class="rightNav" id="account">
                    <p><?php echo strtoupper($_SESSION['username']);?></p>
                    <a href="accountPage.php">
                        <img src="images/accountIcon.png" alt="User" class="userIcon">
                    </a>
                </div>
            </nav>
        </header>
        <center><div id="mainHub">
            <?php
                echo "<h2>Hello {$_SESSION['username']}<br></h2>";
                if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true){
                    echo"admin button WIP";
                }
            ?>
            <div id="gridB">
                
            </div>
        </div></center>
        <footer>
            <form method="post">
                <input type="submit" name="logout" value="Logout">
            </form>
        </footer>
    </body>
</html>