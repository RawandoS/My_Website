<?php

class User{
    use Model;

    private $table = "users";

    public function register($data = []){
        $sql = "INSERT INTO users (user, password, gender, birthDate, iconPath)
                    VALUES (?, ?, ?, ?, ?)";
        $result = $this->query($sql,$data);
        if(is_bool($result) && $result == false){
            return false;
        }
        return true;
    }

    public function login($data = []){
        $sql = "SELECT username, password FROM users
                WHERE user = ? LIMIT 1";
        $result = $this->query($sql,$data);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }
}
