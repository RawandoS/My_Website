<?php

class Home extends Controller{
    public function index(){
        $model = new Model();
        $model->test();

        echo "This is home controller";

        $this->view('home');
    }
}