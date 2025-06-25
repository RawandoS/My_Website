<?php

class User{
    use Model;

    private $table = "users";

    public function validate($data){
        $this->errors = [];

        if(empty($data['user'])){
            $this->errors['user'] = 'Username is required';
        }

        if(empty($data['password'])){
            $this->errors['password'] = 'Password is required';
        }

        if(empty($this->errors)){
            return true;
        }
        return false;
    }

    public function validatePassword($data){
        $this->errors = [];
        
        if(empty($data['oldPassword'])){
            $this->errors['password'] = 'Old passowrd is required';
        }
        if(empty($data['newPassword'])){
            $this->errors['newPassword'] = 'New password is required';
        }
        if(empty($data['newConfirmPassword'])){
            $this->errors['newConfirmPassword'] = 'New Confirm password is required';
        }
        if($data['newPassword'] != $data['newConfirmPassword']){
            $this->errors['pass'] = 'New password don\'t match';
        }

        if(empty($this->errors)){
            return true;
        }
        return false;
    }

    public function register($data = []){
        $sql = "INSERT INTO users (user, password, iconPath)
                    VALUES (:user, :password, :iconPath)";
        $result = $this->query($sql, [
            ':user' => $data['user'],
            ':password' => $data['password'],
            ':iconPath' => $data['iconPath'] ?? 'icons/default.png'
        ]);
        if(is_bool($result) && $result == false){
            return false;
        }
        return true;
    }

    public function login($data = []){
        $sql = "SELECT * FROM users
                WHERE user = :user LIMIT 1";
        $result = $this->query($sql,[
            ":user"=> $data["user"]
        ]);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }

    public function updatePassword($data = []){
        $sql = "UPDATE users SET password = :password
                WHERE user = :user";
        $result = $this->query($sql,[
            ":password" => $data["password"],
            ":user"=> $data["user"]
        ]);
        if(is_bool($result) && $result == false){
            return false;
        }
        return true;
    }
}
