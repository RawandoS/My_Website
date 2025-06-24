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
}
