<?php

class AccountPage{
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

        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])){
            redirect("logout");
        }

        $user = new User();
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["oldPassword"]) && $user->validatePassword($_POST)){
            $oldPassword = trim(filter_input(INPUT_POST,'oldPassword',
                                FILTER_SANITIZE_SPECIAL_CHARS));
            $newPassword = trim(filter_input(INPUT_POST,'newPassword',
                                FILTER_SANITIZE_SPECIAL_CHARS));
            $newConfirmPassword = trim(filter_input(INPUT_POST,'newConfirmPassword',
                                FILTER_SANITIZE_SPECIAL_CHARS));
            
            if(!password_verify($oldPassword, $_SESSION['password'])){
                echo '<script>alert("Old password not correct")</script>';
                unset($_POST);
                redirect('accountPage');
            }
            if($oldPassword == $newPassword){
                echo '<script>alert("You can\'t use the same password")</script>';
                unset($_POST);
                redirect('accountPage');
            }
            
            $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $data = ["user" => $_SESSION['user'],
                    "password" => $newPassword];

            $check = $user->updatePassword($data);
            if(!$check){
                redirect("main");
            }
            echo '<script>alert("You have updated the password")</script>';
            unset($_POST);
            redirect('accountPage');
        }
        
        $data['errors'] = $user->errors;
        $this->view('accountPage', $data);
    }
}