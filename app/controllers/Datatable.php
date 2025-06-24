<?php

class Datatable{
    use Controller;
    public function index(){
        if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
            $_SESSION['username'] = "";
            $_SESSION['isLoggedIn'] = false;

            redirect('home');
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset( $_POST["row"] )) {
            $row = json_decode($_POST["row"], true);
            $row["albumTime"] = ($row["albumTime"] === "N/A") ? "00:00:00": $row["albumTime"];
            $_SESSION["albumData"] = $row;
            $_SESSION["isFromHome"] = true;

            redirect("modifyAlbum");
        }

        $album = new Album();
        $data = $album->getRows();
        if(is_bool($data) && $data === false){
            $data = [];
            echo "no data was found";
        }
        $this->view('datatable', $data);
    }
}