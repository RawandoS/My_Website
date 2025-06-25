<?php

class AdminSuggestion{
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
        if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
            redirect('login');
        }

        
        $this->view('adminSuggestion');
    }
}