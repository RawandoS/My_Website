<?php

class Main{
    use Controller;

    public string $announcement = "";
    public function index(){
        if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
            $_SESSION['username'] = "";
            $_SESSION['isLoggedIn'] = false;
            redirect('home');
        }
        if (!isset($_SESSION['isLoggedIn'])){
            redirect('login');
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset( $_POST["suggestion"] )) {
            $suggestion = $_POST["suggestion"];
            $timestamp = date("Y-m-d H:i:sa");

            $data = [$suggestion, $timestamp];
            $suggestion = new Suggestion();

            $check = $suggestion->addSuggestion( $data);
            if (!$check) {
                $this->announcement = "Suggestion not added";
                unset($_POST);
            }
            unset($_POST);
            $this->announcement = "Suggestion added";
            redirect('main');
        }
        
        if (!$this->announcement === '') {
            customAlert($this->announcement);
        }
        $this->view('main');
    }
}