<?php
    session_start();
    if (isset($_SESSION["username"]) && $_SESSION["isLoggedIn"]){
        header('Location: home.php');
        exit();
    }
    include("database.php");
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $username = filter_input(INPUT_POST,"username",
                                 FILTER_SANITIZE_SPECIAL_CHARS);    
        $password = filter_input(INPUT_POST,"password",
                                FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (empty($username)) {
            echo "Please enter the username";
        }
        elseif (empty($password)) {
            echo "Please enter the password";
        }else{
            $sql = "INSERT INTO users (user, password)
                    VALUES ('$username', '$password')";
            
            try{
                mysqli_query($conn, $sql);
                echo '<script>alert("You have been registered")</script>';
                header("Location: login.php");
                exit();
            }catch(mysqli_sql_exception $e){
                echo '<script>alert("Username already exists")</script>';
            }
        }
    }

    mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Register</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header>
            <h1>Register</h1>
            <a href="login.php" target="_self">
                <button>Login</button>
            </a>
        </header>
        <div>
            <center>
                <form class="registerForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label>Username:</label><br>
                    <input type="text" name="username"><br>
                    <label>Password:</label><br>
                    <input type="password" name="password"><br>
                    <input type="submit" name="submit" value="Register">
                </form>
            </center>
        </div>
    </body>
</html>