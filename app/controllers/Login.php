<?php

class Login{
    use Controller;
    public function index(){
        if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true){
            redirect('main');
        }
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $user = new User();
            
            $data['user'] = $_POST['user'];
            
            $row = $user->login($_POST);
            if($row){
                $password = $row[0]["password"];
                if(password_verify($_POST['password'], $password)){
                    $_SESSION['user'] = $row[0]['user'];
                    $_SESSION['password'] = $row[0]['password'];
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['isAdmin'] = $row[0]['isAdmin'];
                    $_SESSION['canLog'] = $row[0]['canLog'];
                    $_SESSION['gender'] = $row[0]['gender'];
                    $_SESSION['birthDate'] = $row[0]['birthDate'];
                    $_SESSION['bio'] = $row[0]['bio'];
                    redirect("main");
                }
            }
            
        }
        

        $this->view('login');
    }
}