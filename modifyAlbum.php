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

    $albumCoverPath = (file_exists($_SESSION["albumData"]["albumCoverPath"])) ? "{$_SESSION["albumData"]["albumCoverPath"]}" : "images/defaultVinyl.png";
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
                <div class="leftNav">
                    <a href="home.php" target="_self">
                        <button>Home</button>
                    </a>
                </div>
                <div class="rightNav">
                    <a href="coverShow.php" target="_self">
                        <button>Album Covers</button>
                    </a>
                </div>
            </nav>
        </header>
        <div class="centerGrid">
            <form class="modifyAlbum" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                <p>
                    <label>Title:</label>                    
                    <input type="text" name="title" value="<?php echo $_SESSION["albumData"]["title"] ?>"><br>
                </p>
                <p>
                    <label>Artitsts:</label>
                    <input type="text" name="artists" value="<?php echo $_SESSION["albumData"]["artists"] ?>"><br>
                </p>
                <p>
                    <label>Year:</label>
                    <input type="number" min="1000" max="2100" name="year" value="<?php echo $_SESSION["albumData"]["year"] ?>"><br>
                </p>
                <p>
                    <label>Genres:</label>
                    <input type="text" name="genres" value="<?php echo $_SESSION["albumData"]["genres"] ?>"><br>
                </p>
                <p>
                    <label>Styles:</label>
                    <input type="text" name="styles" value="<?php echo $_SESSION["albumData"]["styles"] ?>"><br>
                </p>
                <p>
                    <label>Labels:</label>
                <input type="text" name="labels" value="<?php echo $_SESSION["albumData"]["labels"] ?>"><br>
                </p>
                <p>
                    <label>Track Names:</label>
                    <input type="text" name="trackNames" value="<?php echo $_SESSION["albumData"]["trackNames"] ?>"><br>
                </p>
                <p>
                    <label>Track Times:</label>
                    <input type="text" name="trackTimes" value="<?php echo $_SESSION["albumData"]["trackTimes"] ?>"><br>
                </p>
                <p>
                    <label>Album Lenght:</label>
                    <input type="text" name="albumTime" value="<?php echo $_SESSION["albumData"]["albumTime"] ?>"><br>
                </p>
                <p class="imageUpload">
                    <label class="centerLabel" >Image:</label>
                    <label for="fileInput">
                        <img class="uploadImg" src="<?php echo $albumCoverPath ;?>" style="pointer-events: none">
                    </label>
                    <input type="file" id="fileInput" name="fileInput"><br>
                </p>
                <input class="inputCenter" type="submit" name="submit" value="Modify Album">
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
                    $targetFile = "covers/".$_POST["title"].".jpg";
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    $check = true;
                    
                    if (empty($_FILES["fileInput"]["tmp_name"])) {
                        $uploadFile = [
                            'tmp_name' => "images/defaultVinyl.png",
                            'size' => filesize("images/defaultVinyl.png"),
                            'error' => 0
                        ];
                        $targetFile = "images/defaultVinyl.png";
                    } else {
                        $uploadFile = $_FILES["fileInput"];
                    }
                    try{
                        $check = getimagesize($uploadFile["tmp_name"]);
                        if (!$check){
                            echo '<script>alert("File in not an image")</script>';
                            exit();
                        }else{
                            if ($uploadFile["size"] > 500000) {
                                echo '<script>alert("File is too large")</script>';
                                exit();
                            }
                            if($imageFileType != "jpg" && $imageFileType != "jpeg") {
                                echo '<script>alert("File is not jpg or jpeg")</script>';
                                exit();
                            }
                            $targetFile = preg_replace('/\s+/', '_', $targetFile);
                            if ($targetFile !== "images/defaultVinyl.png") {
                                if (move_uploaded_file($uploadFile['tmp_name'],$targetFile)){
                                    $row = $_POST;
                                    $row['albumId'] = $_SESSION["albumData"]['albumId'];
                                    include("albumDatabase.php");
                                    $check = updateAlbumValues($row);
                                    if (!$check){
                                        echo '<script>alert("Database was not updated")</script>';
                                    }
                                    if ($_SESSION["isFromHome"] === true){
                                        echo '<script>
                                            alert("The changes were successfull");
                                            window.location.href = "home.php";
                                        </script>';
                                        exit();
                                    }elseif ($_SESSION["isFromHome"] === false){
                                        echo '<script>
                                            alert("The changes were successfull");
                                            window.location.href = "coverShow.php";
                                        </script>';
                                        exit();
                                    }else{
                                        echo '<script>alert("Where did you come from")</script>';
                                        header('Location:home.php');
                                        exit();
                                    }
                                    
                                }else {
                                    echo '<script>alert("The file has not been uploaded")</script>';
                                    exit();
                                }
                            }
                        }
                    }catch(Exception $e){
                        echo '<script>alert("Error in the path")</script>';
                        exit();
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