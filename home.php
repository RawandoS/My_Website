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

    include("database.php");
    $sql = "SELECT albumId, title, artists, year, albumTime FROM albums ";
    $result = mysqli_query($conn, $sql);
    $data = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if ($row["albumTime"] == "00:00:00") {
                $row["albumTime"] = "N/A";
            }
            $row["artists"] = str_replace(",",", ", $row["artists"]);
            $data[] = $row;
        }
    }
    mysqli_close($conn);
?>  
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Home Page</title>
        <link rel="stylesheet" href="CSS/style.css" media="screen">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
    </head>
    <body>
        <header>
            <div class="hub">
                <h2>HUB</h2>
            </div>
            <nav class="navbar">
                <div class="leftNav">
                    <a href="glass.php" target="_self">
                        <button>Glass Maker</button>
                    </a>
                </div>
                <div class="center">
                    <?php
                        if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == true){
                            echo '<a href="admin.php" target="_self">
                                <button>To database control</button>
                            </a>';
                        }
                    ?>
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
        <center><div id="mainHub">
            <div id="gridB">
                <table id="example" class="display">
                    <thead>
                        <tr>
                            <th>Album ID</th>
                            <th>Title</th>
                            <th>Artists</th>
                            <th>Year</th>
                            <th>Album Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($data as $row){
                                echo "<tr>
                                    <td>{$row['albumId']}</td>
                                    <td>{$row['title']}</td>
                                    <td>{$row['artists']}</td>
                                    <td>{$row['year']}</td>
                                    <td>{$row['albumTime']}</td>
                                </tr>";
                            }
                        ?>
                    <tfoot>
                        <tr>
                            <th>Album ID</th>
                            <th>Title</th>
                            <th>Artists</th>
                            <th>Year</th>
                            <th>Album Time</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div></center>
        <footer>
            <form method="post">
                <input type="submit" name="logout" value="Logout">
            </form>
        </footer>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    scrollY: '60vh',
                    scrollCollapse: true,
                    fixedHeader: {
                        footer: true
                    }
                });
            });
        </script>
    </body>
</html>