<?php

class Home extends Controller{
    public function index(){
        echo "This is home controller";
    }
}

$home = new Home();
$home->index();