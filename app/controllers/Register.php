<?php

class Register{
    use Controller;
    public function index(){
        if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true){
            redirect('home');
        }
        $user = new User();
        if($user->validate($_POST)){
            $_POST['username'] = trim(filter_input(INPUT_POST,'username',
                                FILTER_SANITIZE_SPECIAL_CHARS));
            $_POST['password'] = trim(filter_input(INPUT_POST,'password',
                                FILTER_SANITIZE_SPECIAL_CHARS));
            
            $_POST['iconPath'] = "http://localhost/public/assets/images/accountIcons/".$_POST['user'].".jpg";
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user = $user->register($_POST);
            //TODO: error handling
            redirect("login");
        }
        
        $data['errors'] = $user->errors;
        $this->view('register', $data);
    }
}