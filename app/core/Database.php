<?php

Trait Database{
    private function connect(){
        $string = "mysql:hostname=".DBHOST.";dbname=".DBANME;
        $conn = new PDO($string,DBUSER,DBPASS);
        return $conn;
    }

    public function query($sql, $data = []){
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $check = $stmt->execute($data);
        if($check){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(is_array($result) && count($result)){
                return $result;
            }
        }
        return false;
    }
}