<?php

class Logout{
    use Controller;
    public function index(){
        $_SESSION['username'] = "";
        $_SESSION['isLoggedIn'] = false;
        session_destroy();

        $this->view('home');
    }
}