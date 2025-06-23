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

    public function deleteSuggestion($id, $id_column = "id"){
        $sql = "DELETE FROM suggestions 
                    WHERE id = ?";
        $result = $this->query($sql,$id);
        if(is_bool($result) && $result == false){
            return false;
        }
        return true;
    }
}
