<?php

class CoverShow{
    use Controller;
    public function index(){
        if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
            $_SESSION['username'] = "";
            $_SESSION['isLoggedIn'] = false;
            redirect('home');
        }
        if (!isset($_SESSION['isLoggedIn'])){
            redirect('login');
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset( $_POST["row"] )) {
            $row = json_decode($_POST["row"], true);
            $row["albumTime"] = ($row["albumTime"] === "N/A") ? "00:00:00": $row["albumTime"];
            $_SESSION["albumData"] = $row;
            $_SESSION["isFromHome"] = false;

            redirect("modifyAlbum");
        }
        
        $start = 0;
        $rowPerPage = 12;
        $page = 1;

        $album = new Album();
        $totRows = $album->getNumRows();

        $pages = ceil( $totRows / $rowPerPage );
        if(isset($_GET["pageNum"])){
            $page = $_GET["pageNum"] -1;
            $start = $page * $rowPerPage;
        }

        $result = $album->getRowsPagination($start, $rowPerPage);
        $result['page'] = $page;
        $result['pages'] = $pages;

        $this->view('coverShow', $result);
    }
}