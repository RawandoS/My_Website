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
}
