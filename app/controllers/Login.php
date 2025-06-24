<?php

class Login{
    use Controller;
    public function index(){
        if(isset($_SESSION) && $_SESSION['isLoggedIn'] === true){
            redirect('home');
        }
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $user = new User();
            
            $data['user'] = $_POST['user'];
            
            $row = $user->login($_POST);
            if($row){
                print_r($row);
                $password = $row[0]["password"];
                if(password_verify($_POST['password'], $password)){
                    $_SESSION['user'] = $row[0]['user'];
                    $_SESSION['passowrd'] = $row[0]['password'];
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['isAdmin'] = $row[0]['isAdmin'];
                    $_SESSION['canLog'] = $row[0]['canLog'];
                    redirect("home");
                }
            }
            
        }
        

        $this->view('login');
    }
}