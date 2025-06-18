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
    if (!isset($_SESSION['isLoggedIn'])){
        header('Location: login.php');
        exit();
    }
    if (isset($_POST["logout"])){
        $_SESSION['username'] = "";
        $_SESSION['isLoggedIn'] = false;
        session_destroy();
        header('Location: index.php');
    }
    include("database.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Account Page</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header>
            <nav class="navbar">
                <div class="leftNav">
                    <?php 
                        echo "<h1>{$_SESSION["username"]}</h1>";
                    ?>
                </div>
                <div class="rightNav" id="account">            
                    <a href="home.php" target="_self">
                        <button>Home</button>
                    </a>
                </div>
            </nav>
        </header>
        <div class="centerGrid">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <label>Old password:</label><br>
                <input type="password" name="oldPassword"><br>
                <label>New password:</label><br>
                <input type="password" name="newPassword" minlength="8"><br>
                <label>Confirm new password:</label><br>
                <input type="password" name="newPasswordConf" minlength="8"><br>
                <input type="submit" name="submit" value="Change password">
            </form>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset( $_POST["oldPassword"])){
                    $oldPassword = filter_input(INPUT_POST,"oldPassword",
                                    FILTER_SANITIZE_SPECIAL_CHARS);    
                    $newPassword = filter_input(INPUT_POST,"newPassword",
                                            FILTER_SANITIZE_SPECIAL_CHARS);
                    $newPasswordConf = filter_input(INPUT_POST,"newPasswordConf",
                                            FILTER_SANITIZE_SPECIAL_CHARS);
                    
                    if(empty($oldPassword) || empty($newPassword) || empty($newPasswordConf)){
                        echo '<script>alert("Do not leave any blank spaces")</script>';
                        exit();
                    }
                    $oldPassword = trim($oldPassword);
                    $newPassword = trim($newPassword);
                    $newPasswordConf = trim($newPasswordConf);

                    if (!password_verify($oldPassword,$_SESSION["password"])){
                        echo '<script>alert("Old password not correct")</script>';
                        exit();
                    }
                    if ($newPassword != $newPasswordConf){
                        echo '<script>alert("The two new password are not the same")</script>';
                        exit();
                    }
                    $oldPassword = $_SESSION["password"];
                    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    $sql = "UPDATE users SET password = '$newPassword'
                            WHERE password = '$oldPassword'";
                    try {
                        mysqli_query($conn, $sql);
                        echo '<script>alert("You have updated the password")</script>';
                        exit();
                    } catch (mysqli_sql_exception $e) {
                        echo '<script>alert("Error in the database")</script>';
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