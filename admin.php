<?php
    session_start();
    if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
        header('Location: login.php');
        exit();
    }
    include("albumDatabase.php");
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
        <div class="centralGrid">
            <div class="leftgrid">
                <center>
                    <form class="databaseForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <label>Album to add (Artist + albumName):</label><br>
                        <input type="text" name="albumName"><br>
                        <input type="submit" name="submit" value="Add to Database">
                    </form>
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["albumName"])){
                            
                            $albumName = filter_input(INPUT_POST,"albumName",
                                            FILTER_SANITIZE_SPECIAL_CHARS);
                            if (empty($albumName)) {
                                echo '<script>alert("Add a real name")</script>';
                                exit();
                            }
                            $check = addAlbumToDatabase($albumName);
                            if (!$check) {
                                echo "Album not added";
                            }
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }
                    ?>
                </center>
            </div>
            <div class="rightGrid">
                <center>
                    <form class="databaseForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <label>Album to add:</label><br>
                        <input type="text" name="albumID"><br>
                        <input type="submit" name="submit" value="Search from Database">
                    </form>
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["albumID"])){
                            $albumID = filter_input(INPUT_POST,"albumID",
                                            FILTER_SANITIZE_SPECIAL_CHARS);
                            if (empty($albumID)) {
                                echo '<script>alert("Add a real name")</script>';
                                exit();
                            }
                            printAlbumFromDatabase($albumID);
                            $_POST ["albumID"] = "";
                        }
                    ?>
                </center>
            </div>
        </div>
        <footer>

        </footer>
    </body>
</html>