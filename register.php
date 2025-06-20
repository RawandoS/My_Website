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
        $gender = $_POST["gender"];
        $date = $_POST["birthDate"];
        
        if (empty($username)) {
            echo '<script>alert("Please enter the username")</script>';
        }
        elseif (empty($password)) {
            echo '<script>alert("Please enter the password")</script>';
        }elseif (empty($gender)){
            echo '<script>alert("Please enter your gender")</script>';
        }elseif (empty($date)) {
            echo '<script>alert("Please enter the date")</script>';
        }
        else{
            $username = trim($username);
            $password = trim($password);
            
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $iconPath = "icons/".$username.".jpg";

            $sql = "INSERT INTO users (user, password, gender, birthDate, iconPath)
                    VALUES ('$username', '$password', '$gender', '$date', '$iconPath')";
            
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
            <div class="hub">
                <h2>REGISTER</h2>
            </div>
            <nav class="navbar">
                <div class="leftNav">
                    <a href="login.php" target="_self">
                        <button>Login</button>
                    </a>
                </div>
                <div class="rightNav">
                    <a href="index.php" target="_self">
                        <button>Home page</button>
                    </a>
                </div>
            </nav>
        </header>
        <div>
            <center>
                <form class="registerForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <label>Username:</label><br>
                    <input type="text" name="username"><br>
                    <label>Password:</label><br>
                    <input type="password" name="password" minlength="8"><br>
                    <select name="gender" >
                        <option value="m">Male</option>
                        <option value="f">Female</option>
                        <option value="x">idc</option>
                    </select><br>
                    <label>Birth Date:</label><br>
                    <input type="date" name="birthDate">
                    <input type="submit" name="submit" value="Register">
                </form>
            </center>
        </div>
    </body>
</html>