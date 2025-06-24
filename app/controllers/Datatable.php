<?php

class Datatable{
    use Controller;
    public function index(){
        if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
            $_SESSION['username'] = "";
            $_SESSION['isLoggedIn'] = false;
            redirect('home');
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