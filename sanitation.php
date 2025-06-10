<?php
    session_start();
    if (!isset($_SESSION['isLoggedIn'])){
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Sanitation</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
    </head>
    <body>
        <header>Sanitations</header>
        <a href="glass.php" target="_self">
            <button>To Make Glass</button>
        </a>
        <form action="home.php" method="post">
            <label>username:</label><br>
            <input type="text" name="username"><br>
            <label>age:</label><br>
            <input type="number" name="age" min="0" max="255"><br>
            <label>email:</label><br>
            <input type="email" name="email"><br>
            <input type="submit" name="login" value="Submit">
        </form>
        <footer>
            <a href="home.php">Home</a>
            <a href="index.php">Index</a>
        </footer>
    </body>
</html>
<?php
    
    if (isset($_POST["login"])) {
        $username = filter_input(INPUT_POST,"username",
                                 FILTER_SANITIZE_SPECIAL_CHARS);    
        
        $age = filter_input(INPUT_POST,"age",
                            FILTER_SANITIZE_NUMBER_INT);
        
        $email = filter_input(INPUT_POST,"email",
                    FILTER_SANITIZE_EMAIL);

        echo "Hello {$username}, you're {$age} and you're email is {$email}";
    }
?>