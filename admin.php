<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        
        try {
            if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
                throw new Exception('Unauthorized access');
            }

            if (!isset($_POST["suggestionId"])) {
                throw new Exception('No suggestion ID provided');
            }

            $id = (int)$_POST["suggestionId"];
            include("database.php");

            $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
            if (!$conn) {
                throw new Exception("Database connection failed");
            }

            $sql = mysqli_prepare($conn, 
            "DELETE FROM suggestions 
                    WHERE id = ?"
            );
            mysqli_stmt_bind_param(
            $sql,
            'i',
            $id
            );
            mysqli_stmt_execute($sql);

            if (mysqli_stmt_num_rows($sql) > 0) {
                throw new Exception('Id may not exists');
            }

            echo json_encode(["success" => true, "id" => $id, "message" => "processed id: $id"]);
            exit();

        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => "Error: ". $e->getMessage()]);
            exit();
        }
    }

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
    if (isset($_POST["logout"])){
        $_SESSION['username'] = "";
        $_SESSION['isLoggedIn'] = false;
        session_destroy();
        header('Location: index.php');
    }
    
    include("database.php");
    $sql = "SELECT * FROM suggestions";
    $result = mysqli_query($conn, $sql);
    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    mysqli_close($conn);

    
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
                    foreach($data as $row){
                        echo "<article class=\"suggestion\">
                                <div class=\"suggestionBox\">
                                    <p><strong>".htmlspecialchars($row["suggestion"])."</strong></p>
                                    <input type=\"hidden\" name=\"id\" value=".$row["id"].">
                                    <button type=\"button\" class=\"deleteBtn\">Delete</button>
                                </form>
                            </article>";
                    }
                ?>
            </div>
        </div>
        <footer>
            <form method="post">
                <input type="submit" name="logout" value="Logout">
            </form>
        </footer>
        <script src="JS\suggestion.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </body>
</html>