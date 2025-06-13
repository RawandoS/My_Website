<?php
    session_start();
    if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Page</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header>
            <div class="hub">
                <h2>DATABSE CONTROL</h2>
            </div>
            <nav class="navbar">
                <div class="leftNav">
                    <a href="home.php" target="_self">
                        <button>Home</button>
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
        <div>
            <center>
                <form class="databaseForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label>Album to add:</label><br>
                    <input type="text" name="albumName"><br>
                    <input type="submit" name="submit" value="Add to Database">
                </form>
            </center>
        </div>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                $albumNAme = filter_input(INPUT_POST,"albumName",
                                 FILTER_SANITIZE_SPECIAL_CHARS);
                if (empty($albumNAme)) {
                    echo '<script>alert("Add a real name")</script>';
                    exit();
                }
                include("albumDatabase.php");
                $check = addAlbumToDatabase($albumNAme);
                if (!$check) {
                    echo "Album not added";
                }
                $_POST ["albumName"] = "";
            }
        ?>
        <footer>

        </footer>
    </body>
</html>