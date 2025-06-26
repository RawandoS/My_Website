<?php

class Suggestion{
    use Model;

    private $table = "suggestions";

    public function addSuggestion($data = []){
        $sql = "INSERT INTO suggestions (suggestion, timestamp)
                VALUES (?, ?)";
        $result = $this->query($sql,$data);
        if(is_bool($result) && $result == false){
            return false;
        }
        return true;
    }

    public function selectFrom() {
        $sql = "SELECT * FROM $this->table LIMIT 12";
        $result = $this->query($sql);
        if(is_bool($result) && $result == false){
            return false;
        }
        return $result;
    }

    public function deleteSuggestion($data = []){
        $sql = "DELETE FROM suggestions 
                    WHERE id = :id";
        $result = $this->query($sql, [
            ":id"=> $data["id"]
        ]);
        if(is_bool($result) && $result == false){
            return false;
        }
        return true;
    }
}
