<?php

class ModifyAlbum{
    use Controller;
    public function index(){
        if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
            $_SESSION['username'] = "";
            $_SESSION['isLoggedIn'] = false;

            redirect('home');
        }

        
        $data = $_SESSION["albumData"];
        show($data);
        
        $this->view('modifyAlbum', $data);
    }
}