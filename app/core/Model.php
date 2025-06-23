<?php

class Model {
    use Database;

    public function test(){
        $sql = "SELECT * FROM users";
        $result = $this->query($sql);
        show($result);
    }
}