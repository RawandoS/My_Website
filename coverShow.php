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
    if (isset($_POST["logout"])){
        $_SESSION['username'] = "";
        $_SESSION['isLoggedIn'] = false;
        session_destroy();
        header('Location: index.php');
    }
    include("pagination.php");

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
    <?php
        if (isset($_GET["pageNum"])) {
            $id = $_GET["pageNum"];
        } else{
            $id = 1;
        }
    ?>
    <body id="<?php echo $id; ?>">
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
        <div class="pageInfo">
            <?php
                if(!isset($_GET["pageNum"])){
                    $page = 1;
                }else{
                    $page = $_GET["pageNum"];
                }
            ?>
            <h3>Showing page <?php echo $page; ?> of <?php echo $pages;?></h3>
        </div>
        <div class="gridBigCover">
            <?php
                while($row = $result->fetch_assoc()){
                    $imgPath = (file_exists("covers/".preg_replace('/\s+/', '_', $row["title"]).".jpg")) ? "{$row["albumCoverPath"]}" : "images/defaultVinyl.png";
                    $imgPath = preg_replace('/\s+/', '_', $imgPath)
                    ?>
                        <article class="album">
                        <h1><?php
                            if (str_word_count($row['title']) <= 6) {
                                echo $row["title"];
                            } else{
                                $token = strtok($row["title"], ' ');
                                $title = "";
                                $counter = 0;
                                while($counter <= 6) {
                                    $title .= $token." ";
                                    $token = strtok(' ');
                                    $counter++;
                                }
                                echo $title."...";
                            }
                        ?></h1>
                        <form action="" method="post">
                            <input type="hidden" name="row" value="<?php echo htmlspecialchars(json_encode($row))?>">
                            <input class="cover" type="image" src="<?php echo $imgPath?>" alt="No image found">
                        </form>
                    </article>
                    <?php
                }
            ?>
        </div>
        <div class="pagination">
            <a href="?pageNum=1">First</a>
            
            <?php
                if(isset($_GET["pageNum"]) && $_GET["pageNum"] > 1){
                    echo "<a href=\"?pageNum=".($_GET["pageNum"] - 1)."\">Previus</a>";
                } else{
                    echo "<a>Previous</a>";
                }
            ?>

            <div class="pageNumbers">
                <?php
                    for($i = 1; $i <= $pages; $i++){
                        echo "<a href=\"?pageNum=".$i."\">".$i."</a>";
                    }
                ?>
            </div>

            <?php
                if(!isset($_GET["pageNum"])) {
                    echo "<a href=\"?pageNum=2\">Next</a>";
                }else{
                    if(isset($_GET["pageNum"]) && $_GET["pageNum"] < $pages){
                        echo "<a href=\"?pageNum=".($_GET["pageNum"] + 1)."\">Next</a>";
                    } else{
                        echo "<a>Next</a>";
                    }
                }
            ?>

            <a href="?pageNum=<?php echo $pages;?>">Last</a>
        </div>
        <footer>
            <form method="post">
                <input type="submit" name="logout" value="Logout">
            </form>
        </footer>
        <script>
            let links = document.querySelectorAll('.pageNumbers > a');
            let bodyId = parseInt(document.body.id) - 1;
            links[bodyId].classList.add("active");
        </script>
    </body>
</html>