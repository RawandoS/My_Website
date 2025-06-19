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

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rowCount"])){
        $rowToCancel = $_POST["rowCount"];
        $suggetsionFile = file_get_contents('userSuggestions.txt');
        $suggetsionFile = explode("\n", $suggetsionFile);
        $suggetsionFile = array_map('trim', $suggetsionFile);
        $suggetsionFile = array_filter($suggetsionFile);
        unset($suggetsionFile[$rowToCancel]);
        $newLines = implode(PHP_EOL, $suggetsionFile);

        file_put_contents("userSuggestions.txt", $newLines);
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
                            exit();
                        }
                        echo '<script>
                            alert("Album added to the database");
                            window.location.href = "admin.php";
                        </script>';
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
                        $_POST["albumID"] = "";
                    }
                ?>
        </div>
        <div class="suggestionGrid" >
            <h3>User suggestion:</h3>
            <div class="suggestionDiv">
                <?php
                    $check = true;
                    if (filesize("userSuggestions.txt") == 0) {
                        echo "<h3>No suggestion in the box</h3>";
                        $check = false;
                    }
                    if ($check) {
                        $rowCount = 0;
                        $suggetsionFile = fopen("userSuggestions.txt","r+") or die("Unable to open file!");
                        while (!feof($suggetsionFile)) {
                            $line = fgets($suggetsionFile);
                            if (empty($line)) {
                                continue;
                            }
                            echo "<article class=\"suggestion\">
                                <form action=\"\" method=\"post\">
                                    <p><strong>".htmlspecialchars($line)."</strong></p>
                                    <input type=\"hidden\" name=\"rowCount\" value=".$rowCount.">
                                    <input type=\"submit\" name=\"submit\" value=\"\">
                                </form>
                            </article>";
                            $rowCount++;
                        }
                    fclose($suggetsionFile);
                    }
                ?>
            </div>
        </div>
        <footer>
            
        </footer>
    </body>
</html>