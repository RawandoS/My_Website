<?php

class Main{
    use Controller;
    public function index(){
        
        $this->view('main');
    }
}