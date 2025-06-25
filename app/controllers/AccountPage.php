<?php

class AccountPage{
    use Controller;

    private $updateErrors = [];
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

        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["gender"])){
            $newUser = $bio = trim(filter_input(INPUT_POST,'user',
                                FILTER_SANITIZE_SPECIAL_CHARS));
            if(empty($newUser)){
                $this->updateErrors['newUser'] = 'New user is required';
                redirect('accountPage');
            }
            $gender = $_POST['gender'];
            $birthDate = $_POST['birthDate'];
            $bio = trim(filter_input(INPUT_POST,'bio',
                                FILTER_SANITIZE_SPECIAL_CHARS));

            if(time() < strtotime('+14 years', strtotime($birthDate))){
                echo '<script>alert("You don\'t meet the age requirements")</script>';
            }
            
            if(arrayContainsSameValues($_POST, $_SESSION)){
                echo '<script>alert("Profile already has this values")</script>';
                show($_POST);

            }else{
                $data = $_POST;
                $data['user'] = $newUser;
                $data['gender'] = $gender;
                $data['birthDate'] = $birthDate;
                $data['bio'] = $bio;
                $data['userOld'] = $_SESSION['user'];
                
                $check = $user->updateAccount($data);
                if(!$check){
                    redirect("main");
                }
                echo '<script>alert("You have updated the profile")</script>';
                unset($_POST);
                redirect('accountPage');
            }
        }
        
        $data['errors'] = $user->errors;
        $data['updateErrors'] = $this->updateErrors; 
        $this->view('accountPage', $data);
    }
}