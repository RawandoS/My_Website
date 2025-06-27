<?php

class Logout{
    use Controller;
    public function index(){
        unset($_SESSION["user"]);
        $_SESSION['isLoggedIn'] = false;
        session_destroy();

        $this->view('home');
    }
}