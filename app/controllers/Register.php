<?php

class Register{
    use Controller;
    public function index(){
        if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true){
            redirect('home');
        }
        $user = new User();
        if($_SERVER['REQUEST_METHOD'] === "POST" && $user->validate($_POST)){
            $_POST['username'] = trim(filter_input(INPUT_POST,'username',
                                FILTER_SANITIZE_SPECIAL_CHARS));
            $_POST['password'] = trim(filter_input(INPUT_POST,'password',
                                FILTER_SANITIZE_SPECIAL_CHARS));
            $password = $_POST['password'];
            
            $_POST['iconPath'] = "http://localhost/public/assets/images/accountIcons/".$_POST['user'].".jpg";
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            show($_POST);
            $check = $user->register($_POST);
            if(!$check){
                redirectMessage('register', "DB error: Your autentication failed");
            }
            $_SESSION["login"] = ["username" => $_POST['user'], 'password'=> $password];
            redirectMessage('login', "Your account has been registered");
        }
        
        $data['errors'] = $user->errors;
        $this->view('register', $data);
    }
}