<?php
    session_start();
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
    if (!isset($_SESSION['isLoggedIn'])) {
        header('Location: login.php');
        exit();
    }

    $title = isset($_POST['title']) ? $_POST['title'] : $_SESSION["albumData"]["title"];
    $artists = isset($_POST['artists']) ? $_POST['artists'] : $_SESSION["albumData"]["artists"];
    $year = isset($_POST['year']) ? $_POST['year'] : $_SESSION["albumData"]["year"];
    $genres = isset($_POST['genres']) ? $_POST['genres'] : $_SESSION["albumData"]["genres"];
    $styles = isset($_POST['styles']) ? $_POST['styles'] : $_SESSION["albumData"]["styles"];
    $labels = isset($_POST['labels']) ? $_POST['labels'] : $_SESSION["albumData"]["labels"];
    $trackNames = isset($_POST['trackNames']) ? $_POST['trackNames'] : $_SESSION["albumData"]["trackNames"];
    $trackTimes = isset($_POST['trackTimes']) ? $_POST['trackTimes'] : $_SESSION["albumData"]["trackTimes"];
    $albumTime = isset($_POST['albumTime']) ? $_POST['albumTime'] : $_SESSION["albumData"]["albumTime"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Modify Album</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header>
            <div class="hub">
                <h2>MODIFY ALBUM</h2>
            </div>
            <nav class="navbar">
                <div class="center">
                    <a href="home.php" target="_self">
                        <button>Home</button>
                    </a>
                </div>
            </nav>
        </header>
        <div class="centerGrid">
            <form class="modifyAlbum" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <p>
                    <label>Title:</label>
                    <input type="text" name="title" value="<?php echo $title ?>"><br>
                </p>
                <p>
                    <label>Artitsts:</label>
                    <input type="text" name="artists" value="<?php echo $artists ?>"><br>
                </p>
                <p>
                    <label>Year:</label>
                    <input type="number" min="1000" max="2100" name="year" value="<?php echo $year ?>"><br>
                </p>
                <p>
                    <label>Genres:</label>
                    <input type="text" name="genres" value="<?php echo $genres ?>"><br>
                </p>
                <p>
                    <label>Styles:</label>
                    <input type="text" name="styles" value="<?php echo $styles ?>"><br>
                </p>
                <p>
                    <label>Labels:</label>
                <input type="text" name="labels" value="<?php echo $labels ?>"><br>
                </p>
                <p>
                    <label>Track Names:</label>
                    <input type="text" name="trackNames" value="<?php echo $trackNames ?>"><br>
                </p>
                <p>
                    <label>Track Times:</label>
                    <input type="text" name="trackTimes" value="<?php echo $trackTimes ?>"><br>
                </p>
                <p>
                    <label>Album Lenght:</label>
                    <input type="text" name="albumTime" value="<?php echo $albumTime ?>"><br>
                </p>
                <p>
                    <label>Image: </label>
                    <input type="file" name="uploadFile"><br>
                </p>
                <input class="inputCenter" type="submit" name="submit" value="Modify Album">
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
                    $targetFile = "covers/".$_POST["title"].".jpg";
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    $check = getimagesize($_FILES["uploadFile"]["tmp_name"]);
                    if (!$check){
                        echo '<script>alert("File in not an image")</script>';
                        exit();
                    }else{
                        if ($_FILES["uploadFile"]["size"] > 500000) {
                            echo '<script>alert("File is too large")</script>';
                            exit();
                        }
                        if($imageFileType != "jpg" && $imageFileType != "jpeg") {
                            echo '<script>alert("File is not jpg or jpeg")</script>';
                            exit();
                        }
                        if (move_uploaded_file($_FILES['uploadFile']['tmp_name'],$targetFile)){
                            echo '<script>alert("The file has been uploaded")</script>';
                            
                            $row = $_POST;
                            $row['albumId'] = $_SESSION["albumData"]['albumId'];
                            include("albumDatabase.php");
                            $check = updateAlbumValues($row);
                            if (!$check){
                                echo '<script>alert("Database was not updated")</script>';
                            }
                        }else {
                            echo '<script>alert("The file has not been uploaded")</script>';
                            exit();
                        }
                    }
                }
            ?>
        </div>
        <footer>
            <form method="post">
                <input type="submit" name="logout" value="Logout">
            </form>
        </footer>
    </body>
</html>