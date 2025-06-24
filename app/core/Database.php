<?php

Trait Database{
    private function connect(){
        $string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
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

    public function numRows($sql) {
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $check = $stmt->execute();
        if($check){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $totRows = count($result);
            if(is_int($totRows) && $totRows > 0){
                return $totRows;
            }
        }
        return false;
    }
}