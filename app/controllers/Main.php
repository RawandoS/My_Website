<?php

class Main{
    use Controller;

    public function index(){
        if(isset($_SESSION["canLog"]) && $_SESSION['canLog'] === false){
            $_SESSION['username'] = "";
            $_SESSION['isLoggedIn'] = false;

            redirectMessage('home',"You can't log to the server");
        }
        if (!isset($_SESSION['isLoggedIn'])){
            redirectMessage('login',"You aren't logged to the server");
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset( $_POST["suggestion"] )) {
            $suggestion = $_POST["suggestion"];
            $timestamp = date("Y-m-d H:i:sa");

            if(empty($suggestion) || $suggestion == ""){
                redirectMessage("main","You can't leave an empty suggestion");
            }

            $data = [$suggestion, $timestamp];
            $suggestion = new Suggestion();

            $check = $suggestion->addSuggestion( $data);
            if (!$check) {
                unset($_POST);
                redirectMessage("main","Your suggestion wasn't added");
            }
            unset($_POST);
            redirectMessage("main","Your suggestion was added");
        }
        
        $this->view('main');
    }
}