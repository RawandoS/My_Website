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

    include("database.php");
    $sql = "SELECT * FROM albums ";
    $result = mysqli_query($conn, $sql);
    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    mysqli_close($conn);

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset( $_POST["row"] )) {
        $row = json_decode($_POST["row"], true);
        $_SESSION["albumData"] = $row;
        $_SESSION["isFromHome"] = false;

        header("Location: modifyAlbum.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Albums</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header>
            <div class="hub">
                <h2>ALBUM COVERS</h2>
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
        </header>
        <div class="gridBigCover">
            <?php
                foreach($data as $row) {
                    $imgPath = (file_exists("covers/".preg_replace('/\s+/', '_', $row["title"]).".jpg")) ? "{$row["albumCoverPath"]}" : "images/defaultVinyl.png";
                    $imgPath = preg_replace('/\s+/', '_', $imgPath);
                    echo "<article class=\"album\">
                        <h1>".$row["title"]."</h1>
                        <form action=\"\" method=\"post\">
                            <input type=\"hidden\" name=\"row\" value=\"".htmlspecialchars(json_encode($row))."\">
                            <input class=\"cover\" type=\"image\" src=".$imgPath." alt=\"No image found\">
                        </form>
                    </article>";
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