<?php
    session_start();
    if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
        header('Location: login.php');
        exit();
    }
    if (isset($_SESSION["canLog"]) && $_SESSION["canLog"] == false) {
        echo '<script>
                alert("You are banned from the server");
                window.location.href = "index.php";
            </script>';
        $_SESSION['username'] = "";
        $_SESSION['isLoggedIn'] = false;
        session_destroy();
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
                <h2>DATABASE CONTROL</h2>
            </div>
            <nav class="navbar">
                <div class="leftNav">
                    <a href="home.php" target="_self">
                        <button>Home</button>
                    </a>
                </div>
                <div class="rightNav" id="account">            
                    <a href="accountPage.php">
                        <button>
                            <img src="images/accountIcon.png" alt="User" class="userIcon">
                        </button>
                    </a>
                </div>
            </nav>
        </header>
        <div class="centralGrid">
            <div class="leftGrid">
                <form class="databaseForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label id="addAlbum">Album to add <br>(Artist + albumName):</label><br>
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
                            echo '<script>alert("Album not added")</script>';
                        }
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }
                ?>
            </div>
            <div class="rightGrid">
                <form class="databaseForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label id="insert">Insert album ID:</label><br>
                    <input type="text" name="albumID"><br>
                    <input type="submit" name="submit" value="Search from Database">
                </form>
            </div>
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
        </div>
        <footer>

        </footer>
    </body>
</html>