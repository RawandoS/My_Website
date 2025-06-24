<?php

class Register{
    use Controller;
    public function index(){
        if(isset($_SESSION) && $_SESSION['isLoggedIn'] === true){
            redirect('home');
        }
        $user = new User();
        if($user->validate($_POST))
        {   
            $_POST['iconPath'] = "icons/".$_POST['user'].".jpg";
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = $user->register($_POST);
            redirect("login");
        }
        
        $data['errors'] = $user->errors;

        $this->view('register', $data);
    }
}