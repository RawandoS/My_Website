<?php
    session_start();
    include("database.php");
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = filter_input(INPUT_POST,"username",
                                 FILTER_SANITIZE_SPECIAL_CHARS);    
        $password = filter_input(INPUT_POST,"password",
                                FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (empty($username)) {
            echo '<script>alert("Please enter the username")</script>';
        }
        elseif (empty($password)) {
            echo '<script>alert("Please enter the password")</script>';
        }else{
            $sql = "SELECT * FROM users
                    WHERE user = '$username' LIMIT 1";
            try{
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    $database_username = $row["user"];
                    $database_password = $row["password"];
                    if ($database_username == $username && $database_password == $password) {
                        echo '<script>alert("You are logged in")</script>';
                        echo 'You are logged in';

                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        $_SESSION['isLoggedIn'] = true;

                        header("Location: home.php");
                        exit();
                    }
                }else{
                    echo '<script>alert("Wrong username or password")</script>';
                }
            }catch(mysqli_sql_exception $e){
                echo '<script>alert("Wrong username or password")</script>';
            }
        }
    }

    mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Login</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header>
            <h1>Login</h1>
            <a href="register.php" target="_self">
                <button>Register</button>
            </a>
        </header>
        <div>
            <center>
                <form class="loginForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label>Username:</label><br>
                    <input type="text" name="username"><br>
                    <label>Password:</label><br>
                    <input type="password" name="password"><br>
                    <input type="submit" name="submit" value="Login">
                </form>
            </center>
        </div>
    </body>
</html>