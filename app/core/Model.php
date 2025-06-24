<?php

trait Model {
    use Database;

    public $errors = [];

    public function selectFrom() {
        $sql = "SELECT * FROM $this->table";
        $result = $this->query($sql);
        show($result);
    }

    public function selectFromLimit($limit) {
        $sql = "SELECT * FROM $this->table LIMIT $limit";
        $result = $this->query($sql);
        show($result);
    }



    public function addAlbumToDB($data = []){
        //TODO
    }

    public function updateAlbum($data = []){
        //TODO
    }
}