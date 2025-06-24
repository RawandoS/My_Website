<?php

class Album{
    use Model;

    private $table = "albums";

    public function getRows(){
        $sql = "SELECT * FROM albums";
        $result = $this->query($sql);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }
    
    public function getNumRows(){
        $sql = "SELECT * FROM albums";
        $result = $this->numRows($sql);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }

    public function getRowsPagination($start,$rowPerPage){
        $sql = "SELECT * FROM albums LIMIT $start, $rowPerPage";
        $result = $this->query($sql);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }
}
