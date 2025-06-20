<?php
    include("database.php");
    
    $start = 0;
    $rowPerPage = 15;

    $sql = "SELECT * FROM albums";
    $result = mysqli_query($conn, $sql);
    $totRows = $result->num_rows;
    $pages = ceil($totRows / $rowPerPage);

    if (isset($_GET["pageNum"])) {
        $page = $_GET["pageNum"] - 1;
        $start = $page * $rowPerPage;
    }

    $sql = "SELECT * FROM albums LIMIT $start, $rowPerPage";
    $result = mysqli_query($conn, $sql);
    
?>